<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;
use business\entity\YoyakuRegistration;
use business\entity\YoyakuJson;
use business\entity\Schedule;
use business\entity\Customer;
use business\entity\Config;

class YoyakuInfo
{
    public $menu, $name_kanji, $name_kana, $tell, $email, $staff, $datetime, $youbou, $sum_time, $sum_price, $rireki;
}

class Confirm extends YoyakuMenu
{
    private $_course_id_list;
    private $_course_list;
    private $_staff;

	public function __construct()
	{
        $yc = YoyakuContext::get_instance();
        $this->_course_id_list = $this->get_course_id_list();
        $this->_course_list = \business\facade\get_menu_course_by_idlist($this->_course_id_list);
        $staff_id = $yc->staff_id->get_value();
        if($staff_id == "none"){
            $this->_staff = null;
        }else{
            $this->_staff = \business\facade\get_staff_byid($yc->staff_id->get_value());
        }

        $this->_is_view_footer = false;
	}

	public function pre_render()
	{
        if(isset($_POST["finish_btn"])){
            $yc = YoyakuContext::get_instance();

            $this->save_yoyaku();

            $this->send_mail();

    		$url = $yc->get_base_url()."/finish/";

            header("Location:$url");
        }
	}
    
    const week_table = array("日", "月", "火", "水", "木", "金", "土");

    private function create_yoyaku_info() : YoyakuInfo
    {
        $ret = new YoyakuInfo();
        
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
        $ret->email = $mc->email->get_value();
        
        $menu = "";    
        $sum_time = 0;
        $sum_price = 0;

        foreach($this->_course_list as $c)
        {
            $menu = $menu.$c->name;
            $menu = $menu.'<br>';
            $sum_time = $sum_time + $c->time_required;
            $sum_price = $sum_price + $c->price;
        }

        $ret->menu = $menu;
        $ret->sum_time = $sum_time; 
        $ret->sum_price = number_format($sum_price);

        if($this->_staff == null){
            $ret->staff = "-";
        }else{
            $ret->staff =  $this->_staff->name_last.' '.$this->_staff->name_first;
        }       

        $ret->name_kanji = $mc->name_kanji->get_value();
        $ret->name_kana = $mc->name_kana->get_value();
        $ret->tell = $mc->tell->get_value();
        $visit_kbn = $mc->visit->get_value()[0];
        if($visit_kbn == 0){
            $ret->visit = "初めて";
        }else{
            $ret->visit =  "再来店";
        }

        $d = new \DateTime($yc->yoyaku_date_time->get_value());
        $week = self::week_table[$d->format('w')];
        $ret->date_time = $d->format("Y年m月d日（").$week.$d->format("）　　d時s分");
        $ret->youbou = $mc->consultation->get_value();

        return $ret;
    }

    private function save_yoyaku()
    {
        $yc = YoyakuContext::get_instance();
        $customr_id = $this->get_customer_id();
        \business\facade\update_nextvisit($customr_id, new \DateTime($yc->yoyaku_date_time->get_value()));

        $schedule = $this->create_schedule($customr_id);
        \business\facade\insert_schedule($schedule);
    }

    private function create_schedule($customr_id) : Schedule
    {
        $ret = new Schedule();
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
      
        if($this->_staff == null){
            $ret->staff_id = 'null';
        }else{
            $ret->staff_id =  $this->_staff->id;
        }
        
        $ret->start_time = $yc->yoyaku_date_time->get_value();
        $ret->schedule_division = Schedule::Yoyaku;

        $yoyaku_data = $this->create_yoyaku_json($customr_id);

        $sum_time = 0;

        $course = \business\facade\get_menu_course_by_idlist($this->_course_id_list);

        foreach($course as $c)
        {
           $sum_time = $sum_time + $c->time_required;
        }

        $ret->minutes = $sum_time;

        $ret->data = json_encode($yoyaku_data);

        return $ret;
    }

    private function create_yoyaku_json($customr_id) : YoyakuJson
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;

        $yj = new YoyakuJson();

        $yj->customer_id = $customr_id;

        $yj->start_time = $yc->yoyaku_date_time->get_value();

        $yj->coutse_id_list = $this->_course_id_list;

        $yj->consultation = $mc->consultation->get_value();

        return $yj;
    }

    private function get_customer_id() : int
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;

        $customer_id = \business\facade\select_customer_id_by_email($mc->email->get_value());

        if(is_null($customer_id)){
            $new_customer = new Customer();
            $new_customer->tanto_id = $yr->staff_id;
            $new_customer->name_kanji_last = $mc->name_kanji->get_value();
            $new_customer->name_kana_last = $mc->name_kana->get_value();
            $new_customer->phone_number = $mc->tell->get_value();
            $new_customer->email = $mc->email->get_value();
            $new_customer->remarks = $mc->consultation->get_value();
            \business\facade\InsertCustomer($new_customer);
            $customer_id = \business\facade\select_customer_id_by_email($mc->email->get_value());
        }

        return $customer_id;
    }

    // private function create_yoyaku_registration() : YoyakuRegistration
    // {
    //     $yc = YoyakuContext::get_instance();
    //     $mc = $yc->mail_contents;

    //     $yr = new YoyakuRegistration();
    //     if($this->_staff == null){
    //         $yr->staff_id = 'null';
    //     }else{
    //         $yr->staff_id =  $this->_staff->id;
    //     }

    //     $customer_id = \business\facade\select_customer_id_by_email($mc->email->get_value());

    //     if(is_null($customer_id)){
    //         $new_customer = new Customer();
    //         $new_customer->tanto_id = $yr->staff_id;
    //         $new_customer->name_kanji_last = $mc->name_kanji->get_value();
    //         $new_customer->name_kana_last = $mc->name_kana->get_value();
    //         $new_customer->phone_number = $mc->tell->get_value();
    //         $new_customer->email = $mc->email->get_value();
    //         $new_customer->remarks = $mc->consultation->get_value();
    //         \business\facade\InsertCustomer($new_customer);
    //         $customer_id = \business\facade\select_customer_id_by_email($mc->email->get_value());
    //     }

    //     $yr->customer_id = $customer_id;

    //     $yr->start_time = $yc->yoyaku_date_time->get_value();

    //     $yr->coutse_id_list = $this->_course_id_list;

    //     $yr->consultation = $mc->consultation->get_value();

    //     return $yr;
    // }

    private function send_mail()
    {
        $info = $this->create_yoyaku_info();
        
    	$strSen = <<<SEN
予約内容
メニュー:
$info->menu
施術時間（目安）: $info->sum_time 
料金 : $info->sum_price
セラピスト : $info->staff
来店日時
$info->date_time
お客様情報
お名前（漢字）: $info->name_kanji
お名前（かな）: $info->name_kana
メールアドレス : $info->email
電話番号 : $info->tell
来店履歴 : $info->visit
ご要望 :
$info->youbou
SEN;

        $address = Config::get_instance()->YoyakuMailAddress->get_value();

        wp_mail($address, 'ご予約を受け付けました', $strSen);
    }

	protected function init_inner()
	{
	}

	protected function get_css_list() : array
	{
		return [
		"confirm.css"
		];
	}

	public function get_title() : string
	{
		return "確認画面";
	}


	public function view()
	{
         $info = $this->create_yoyaku_info();
    ?>        
        <div class='yoyaku_midashi'>
            <span class='page_midasi'>予約内容を確認してください</span>
        </div>
    <?php
        $d = "?date=".(new \DateTime())->format("Ymdhis");
		$yc = YoyakuContext::get_instance();
        $before_url = $yc->get_base_url()."/mailform/".$d;
        $this->view_yoyaku_content($info);
        $this->view_customer_info($info);
        ?>
        <div class='privacy_policy_area'>
            <span class='privacy_policy_red'>
                迷惑メール防止フィルタを設定している場合、メールが届かないことがありますので「contact@redear.jp」からのメールが受信できるようドメインの設定をお願いします。
            </span><br>
            <span class='privacy_policy_blue'>
                プライバシーポリシー
            </span>
            <span class='privacy_policy'>
                をご確認いただき、予約を確定してください。
            </span>
        </div>
        <form method='post' action='<?php echo "$d" ?>'>
            <div class='button_area'>
                <div class='back_button_area'>
                    <a class='back_button' href='<?php echo $before_url; ?>'>< 戻る</a>
                </div>
                <div class='back_button_area'>
                    <button type='submit' value='none' name='finish_btn' class='next_button'>予約を確定する</button>
                </div>
            </div>
        </form>
	<?php
	}

    private function view_yoyaku_content(YoyakuInfo $info)
    {
		?>
        <div class="content_wrap">
            <span class='yoyaku_content_midasi'>予約内容</span>
            <div class='table_wrap'>
                <table class='confirm_table'>
                    <tr>
                        <th>
                            メニュー
                        </th>
                        <td>
                            <?php
                            echo $info->menu;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            施術時間（目安）
                        </th>
                        <td>
                            <?php
                            echo $info->sum_time;
                            echo "分";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            料金
                        </th>
                        <td>
                        <?php
                        echo $info->sum_price;
                        echo "円";
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            セラピスト
                        </th>
                        <td>
                            <?php
                            echo $info->staff;
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            来店日時
                        </th>
                        <td>
                            <?php
                            echo $info->date_time;
                            ?>  
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php
    }

    private function view_customer_info(YoyakuInfo $info)
    {
		?>
        <div class="customer_wrap">
            <span class='yoyaku_content_midasi'>お客様情報</span>
            <div class='table_wrap'>
                <table class='confirm_table'>
                    <tr>
                        <th>
                            お名前（漢字）
                        </th>
                        <td>
                            <?php
                            echo $info->name_kanji;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            お名前（かな）
                        </th>
                        <td>
                        <?php
                            echo $info->name_kana;
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            メールアドレス
                        </th>
                        <td>
                            <?php
                            echo $info->email;
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            電話番号
                        </th>
                        <td>
                            <?php
                            echo $info->tell;
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            来店履歴
                        </th>
                        <td>
                            <?php
                            echo $info->visit;
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            ご要望
                        </th>
                        <td>
                            <?php
                            echo $info->youbou;
                            ?>  
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

}

?>