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
    'None' => "指定なし",
    'M' => "男性",
    'F' => "女性"
    ];
  
    public function init()
    {

    }

    public function get_title():string
    {
        return "性別";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->view_radio($param->sex->get_key(), $param->sex->get_value(), self::sex_list);
    }

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->sex;
        return !$param->is_set();
    }
}


class OccupatioCriterie extends Criteria
{
    private $_occupation;

    public function init()
    {
        $this->_occupation =new InputControll("text", $param->occupation->get_key());
    }

    public function get_title():string
    {
        return "職業";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $add = [];
        $add["id"] = $param->occupation->get_key();
        $this->_occupation->set_value($this->_default_msg->occupation);
        $this->_occupation->set_attribute($add);
        $this->_occupation->view();
    }

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->occupation;
        return !$param->is_set();
    }
}


class VisitNumCriterie extends Criteria
{
    private $_vist_num_more, $_vist_num_less;

    public function init()
    {
        $this->_vist_num_more = new InputControll("number", $param->visit_num_more->get_key());
        $this->_vist_num_less = new InputControll("number", $param->visit_num_less->get_key());
    }

    public function get_title():string
    {
        return "職業";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();

        $this->_vist_num_more->set_value($this->_default_msg->visit_num_more);
        $this->_vist_num_less->set_value($this->_default_msg->visit_num_less);

        $add = [];
        $add["min"] = "0";        
        $add["id"] = $param->vist_num_more->get_key();
        $this->_vist_num_more->set_attribute($add);


        $add_less = [];
        $add_less["min"] = "0";        
        $add_less["id"] = $param->vist_num_less->get_key();
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

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->sex;
        return !$param->is_set();
    }
}



?>