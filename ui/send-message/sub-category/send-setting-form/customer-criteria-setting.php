<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class CustomerCriteriaSetting extends SettingForm
{
	private $_sending_mail, $_confirm_mail;
	private $_message;
	private $_occupation;
	private $_vist_num;
	private $_reservation_route;
	private $_staff;
 
    protected function init_inner()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
		$this->_occupation = new InputBase("text", $param->occupation->get_key(), $this->_default_msg->occupation);
		$this->_vist_num_more = new InputBase("number", $param->visit_num->get_more_key(), $this->_default_msg->visit_num_more);
        $this->_vist_num_less = new InputBase("number", $param->visit_num->get_less_key(), $this->_default_msg->visit_num_less);
		$this->_reservation_route = new RouteSelect();
		$this->_reservation_route->set_name($param->reservation_route->get_key());
		$this->_reservation_route->set_selected_id($this->_default_msg->reservation_route);
		$this->_staff = new ViewStaff($param->staff->get_key());

        $sc = SendMessageContext::get_instance();       
        $sc->enable_save_btn();
    }

    protected function get_title() : string
    {
        return "お客様の絞り込み";
    }
 
    const sex_list = [
    'None' => "指定なし",
    'M' => "男性",
    'F' => "女性"
    ];

    const dm_list = [
    '0' => "指定なし",
    '1' => "可",
    '2' => "不可"
    ];
    
    protected function view_radio($name, $selected_name, $d)
    {
        foreach($d as $key => $text)
        {
            
            if($key  == $selected_name){
                echo "<input type='radio' name='$name' value='$key' checked>$text";
            }else{
                echo "<input type='radio' name='$name' value='$key'>$text";
            }
        }
    }
    protected function view_inner()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
    ?>
        <div class="line">
            <h2>
            性別
            </h2>
            <div class=""：>
            <?php
            $this->view_radio($param->sex->get_key(), $param->sex->get_value(), self::sex_list);
            ?>
          
            </div>
        </div>
        
        <div class="line">
            <h2>
            職業
            </h2>
            <div class="">
                <?php $this->_occupation->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            来店回数
            </h2>
            <div class="visit_num_more">
                <?php $this->_vist_num_more->view(); ?>以上
            </div>
            <div class="visit_num_less">
                <?php $this->_vist_num_less->view(); ?>以下
            </div>
        </div>
        <div class="line">
            <h2>
            予約経路
            </h2>
            <div class="">
                <?php $this->_reservation_route->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            担当スタッフ
            </h2>
            <div class="">
                <?php $this->_staff->view_staff_select($param->staff->get_value()); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            DM
            </h2>
            <div class="">
                <?php
                $name = $param->enable_dm->get_key();
                $v = $param->enable_dm->get_value();
                $this->view_radio( $name ,  $v , self::dm_list);
                ?>
            </div>
        </div>

    <?php
    }

}


?>