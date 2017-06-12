<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;

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
        if(isset($_POST["confirm_btn"])){
	    	$yc = YoyakuContext::get_instance();
    		$url = $yc->get_base_url()."/finish/".$d;
            header("Location:$url");
        }
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
    ?>        
        <div class='yoyaku_midashi'>
            <span class='page_midasi'>予約内容を確認してください</span>
        </div>
    <?php
        $d = "?date=".(new \DateTime())->format("Ymdhis");
		$yc = YoyakuContext::get_instance();
        $before_url = $yc->get_base_url()."/mailform/".$d;
        $this->view_yoyaku_content();
        $this->view_customer_info();
        ?>
        <form method='post' action='<?php echo "$d" ?>'>
            <div class='button_area'>
                <div class='back_button_area'>
                    <a class='back_button' href='<?php echo $before_url; ?>'>< 戻る</a>
                </div>
                <div class='back_button_area'>
                    <button type='submit' value='none' name='confirm_btn' class='next_button'>予約を確定する</button>
                </div>
            </div>
        </form>
	<?php
	}

    private function view_yoyaku_content()
    {
        $menu = "";    
        $sum_time = 0;
        $sum_price = 0;

        foreach($this->_course_list as $c)
        {
            $menu = $menu."<br>".$c->name;
            $sum_time = $sum_time + $c->time_required;
            $sum_price = $sum_price + $c->price;
        }

		?>
        <div class="info_warp">
            <span class='yoyaku_content_midasi'>予約内容</span>
            <div class='table_wrap'>
                <table class='confirm_table'>
                    <tr>
                        <th>
                            メニュー
                        </th>
                        <td>
                            <?php
                            echo $menu;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            施術時間（目安）
                        </th>
                        <td>
                            <?php
                            echo $sum_time;
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
                        echo $sum_price;
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
                            if($this->_staff == null){
                                echo "-";
                            }else{
                                echo $this->_staff->name_last.' '.$this->_staff->name_first;
                            }
                            ?>  
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php
    }

    private function view_customer_info()
    {
        $yc = YoyakuContext::get_instance();
        $mc = $yc->mail_contents;
		?>
        <div class="info_warp">
            <span class='yoyaku_content_midasi'>お客様情報</span>
            <div class='table_wrap'>
                <table class='confirm_table'>
                    <tr>
                        <th>
                            お名前（漢字）
                        </th>
                        <td>
                            <?php
                            echo $mc->name_kanji->get_value();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            お名前（かな）
                        </th>
                        <td>
                        <?php
                            echo $mc->name_kana->get_value();
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            メールアドレス
                        </th>
                        <td>
                            <?php
                            echo $mc->email->get_value();
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            電話番号
                        </th>
                        <td>
                            <?php
                            echo $mc->tell->get_value();
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            来店履歴
                        </th>
                        <td>
                            <?php
                            $c = $mc->visit->get_value()[0];
                            if($c == 0){
                                echo "初めて";
                            }else{
                                echo "再来店";
                            }
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <th>
                            ご要望
                        </th>
                        <td>
                            <?php
                            echo $mc->consultation->get_value();
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