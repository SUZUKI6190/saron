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
    const Key = "CustomerKey";

    protected function init_inner()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
		$this->_occupation = new InputBase("text", $param->occupation->get_key(), $this->_default_msg->occupation);
		$this->_vist_num = new InputBase("number", $param->visit_num->get_key(), $this->_default_msg->visit_num);
		$this->_reservation_route = new RouteSelect();
		$this->_reservation_route->set_name($param->reservation_route->get_key());
		$this->_reservation_route->set_selected_id($this->_default_msg->reservation_route);
		$this->_staff = new ViewStaff($param->staff->get_key());
    }

    protected function get_title() : string
    {
        return "お客様の絞り込み";
    }

    protected  function get_page_id() : string
    {
        return self::Key;
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            性別
            </h2>
            <div class=""：>

            <select name="sex" id="sex">
                <option value='None'></option>
                <option value='M'>男性</option>
                <option value='F'>女性</option>
            </select>
    
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
            <div class="">
                <?php $this->_vist_num->view(); ?>
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
                <?php $this->_staff->view_staff_select(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            DM不可を除く
            </h2>
            <div class="">
                <?php
                $param = SendMessageContext::get_instance()->get_param_set();
                $name = $param->enable_dm->get_key();
                $v = $param->enable_dm->get_value();
                if($v == '1'){
                    echo "<input type='radio' name='$name' value='1' checked>含む";
                    echo "<input type='radio' name='$name' value='0' >含まない";
                }else{
                    echo "<input type='radio' name='$name' value='1'>含む";
                    echo "<input type='radio' name='$name' value='0' checked>含まない";
                }
                ?>
            </div>
        </div>

    <?php
    }

    protected function save_post_param()
    {
        SendMessageContext::get_instance()->get_param_set()->set_customer_criteria();
    }

}


?>