<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\send_message\Param;
use ui\util\InputBase;
use ui\util\InputControll;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class SexCriteria extends Criteria
{
    const sex_list = [
    'M' => "男性",
    'F' => "女性"
    ];
  
    protected function init_inner()
    {
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function get_title():string
    {
        return "性別";
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->sex;
    }

    public function get_hidden_id():string
    {
        return str_replace("[]", "", $this->name)."_hdn";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->view_radio($param->sex->get_key(), $param->sex->get_value(), self::sex_list);
    }

    public function clear_criteria()
    {
        $this->get_context_param()->clear();
    }
}


class OccupatioCriterie extends Criteria
{
    private $_occupation;

    protected function init_inner()
    {
        $param = $this->get_context_param();
        $this->_occupation =new InputControll("text", $param->get_key());
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function get_title():string
    {
        return "職業";
    }

    public function view()
    {
        $param = $this->get_context_param();
        $add = [];
        $add["id"] = $param->get_key();
        $this->_occupation->set_value($this->default_msg->occupation);
        $this->_occupation->set_attribute($add);
        $this->_occupation->view();
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->occupation;
    }

}


class VisitNumCriterie extends Criteria
{
    private $_vist_num_more, $_vist_num_less;

    protected function init_inner()
    {
        $param = $this->get_context_param();
        $this->_vist_num_more = new InputControll("number", $param->get_more_key());
        $this->_vist_num_less = new InputControll("number", $param->get_less_key());
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function get_title():string
    {
        return "職業";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set()->visit_num;;

        $this->_vist_num_more->set_value($this->default_msg->visit_num_more);
        $this->_vist_num_less->set_value($this->default_msg->visit_num_less);

        $add = [];
        $add["min"] = "0";        
        $add["id"] = $param->get_more_key();
        $this->_vist_num_more->set_attribute($add);


        $add_less = [];
        $add_less["min"] = "0";        
        $add_less["id"] = $param->get_less_key();
        $this->_vist_num_less->set_attribute($add_less);

        ?>
        <div class="visit_num_more">
                <?php $this->_vist_num_more->view(); ?>以上
            </div>
            <div class="visit_num_less">
                <?php $this->_vist_num_less->view(); ?>以下
            </div>
        <?php
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->visit_num;
    }
}



class ReservationRouteCriterie extends Criteria
{
    private $_reservation_route;

    protected function init_inner()
    {      
		$this->_reservation_route = new RouteSelect();
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function get_title():string
    {
        return "予約経路";
    }

    public function view()
    {
        $param = $this->get_context_param();
  		$this->_reservation_route->set_name($param->get_key());
		$this->_reservation_route->set_selected_id($this->default_msg->reservation_route);
        $this->_reservation_route->view();

    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->reservation_route;
    }

}


class StaffCriterie extends Criteria
{
    private $_reservation_route;

    protected function init_inner()
    {
        $param = $this->get_context_param();
       	$this->_staff = new ViewStaff($param->get_key());
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function get_title():string
    {
        return "担当スタッフ";
    }

    public function view()
    { 
         $this->_staff->view_staff_select($this->get_context_param()->get_value());
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->staff;
    }

}


class EnableDMCriterie extends Criteria
{

    const dm_list = [
    '1' => "可",
    '2' => "不可"
    ];

    public function get_hidden_id():string
    {
        return str_replace("[]", "", $this->name)."_hdn";
    }

    protected function init_inner()
    {
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
	}

    public function get_title():string
    {
        return "DM";
    }

    public function view()
    { 
        $param = $this->get_context_param();
        $name = $param->get_key();
        $v = $param->get_value();
        $this->view_radio( $name ,  $v , self::dm_list);
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->enable_dm;
    }

}



?>