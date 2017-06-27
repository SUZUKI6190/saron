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
        $yc = YoyakuContext::get_instance();
      
        if(isset($_POST["finish_btn"])){
         
            $this->save();

            $this->send_mail();

    		$url = $yc->get_base_url()."/finish/";

            $this->transfer($url);
        }

        if(isset($_POST["back_btn"])){
            $before_url = $yc->get_base_url()."/mailform/";
            $this->transfer($before_url);
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
        $ret->date_time = $d->format("Y年m月d日（").$week.$d->format("）　　H時s分");
        $ret->youbou = $mc->consultation->get_value();

        return $ret;
    }

    private function save()
    {
        $yc = YoyakuContext::get_instance();
        $customr_id = $this->get_customer_id();
        \business\facade\update_nextvisit($customr_id, new \DateTime($yc->yoyaku_date_time->get_value()));

        $this->save_yoyaku_registration($customr_id);
        $regist_id = \business\facade\get_last_insert_id();
        $this->save_schedule($customr_id, $regist_id);
    }

    private function get_staff_id()
    {
        if($this->_staff == null){
            return 'null';
        }else{
            return $this->_staff->id;
        }
    }

    private function save_schedule($customr_id, $regist_id)
    {
        $schedule = $this->create_schedule($customr_id);
        $schedule->data = $regist_id;
        \business\facade\insert_schedule($schedule);
    }

    private function save_yoyaku_registration($customr_id)
    {
        $yoyaku_regist = $this->create_yoyaku_registration($customr_id);
        \business\facade\insert_yoyaku_registration($yoyaku_regist);
    }

    private function create_schedule($customr_id) : Schedule
    {
        $ret = new Schedule();
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
      
        $ret->staff_id = $this->get_staff_id();

        $ret->start_time = $yc->yoyaku_date_time->get_value();
        $ret->schedule_division = Schedule::Yoyaku;

        $sum_time = 0;
        $name = "";

        $course = \business\facade\get_menu_course_by_idlist($this->_course_id_list);

        foreach($course as $c)
        {
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->minutes = $sum_time;

        $ret->schedule_name = $name;

        return $ret;
    }

    private function create_yoyaku_registration($customr_id) : YoyakuRegistration
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;

        $yj = new YoyakuRegistration();

        $yj->staff_id = $this->get_staff_id();

        $yj->customer_id = $customr_id;

        $yj->start_time = $yc->yoyaku_date_time->get_value();

        $yj->course_id_list = implode(",", $this->_course_id_list);

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

    private function send_mail()
    {
        $info = $this->create_yoyaku_info();
        
        $address = Config::get_instance()->YoyakuMailAddress->get_value();
        $title = Config::get_instance()->YoyakuMailTitle->get_value();
        $content = Config::get_instance()->YoyakuMailContent->get_value();
        $menu = "";
        
        foreach($this->_course_list as $c)
        {
            $menu = $menu.sprintf("%c(%d分)\n", $c->name, $c->time_required);  
        }

    	$strSen = <<<SEN
$content

【予約確認】
・日時 
   $info->date_time ～
・メニュー
   $menu
SEN;
        wp_mail($address, $title, $strSen);
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
        <div class='button_area'>
            <div class='back_button_area'>
                <button type='submit' value='none' name='back_btn' class='back_button'>< 戻る</button>
            </div>
            <div class='back_button_area'>
                <button type='submit' value='none' name='finish_btn' class='next_button'>予約を確定する</button>
            </div>
        </div>
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