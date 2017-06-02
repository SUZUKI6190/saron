<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\send_message\Param;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class LastVisitCriteria extends Criteria
{
    private $_last_visit;
  
    public function init()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->name= $param->last_visit->get_key();
        $this->_last_visit = new DayCriteriaForm($param->last_visit->get_key(), $this->default_msg->last_visit);
    }

    public function get_title():string
    {
        return "最終来店日";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_last_visit->view($param->last_visit);
    }

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->last_visit;
        return !$param->is_set();
    }
}


class NextVisitCriteria extends Criteria
{
    private $_next_visit;
 
    public function init()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->name= $param->next_visit->get_key();
        $this->_next_visit = new DayCriteriaForm($param->next_visit->get_key(), $this->default_msg->next_visit);
    }

    public function get_title():string
    {
        return "次回来店予定日";
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_next_visit->view($param->next_visit);       
    }

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->next_visit;
        return !$param->is_set();
    }
}

class BirthVisitCriteria extends Criteria
{
    private $_birth;

    public function get_title():string
    {
        return "誕生日";
    }

    public function init()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->name= $param->birth->get_key();
        $this->_birth= new DayCriteriaForm($param->birth->get_key(), $this->default_msg->birth);
    }

    public function view()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_birth->view($param->birth);
    }

    public function is_hidden():bool
    {
        $param = SendMessageContext::get_instance()->get_param_set()->birth;
        return !$param->is_set();
    }
}


class DayCriteriaForm
{
	private $_name;
	private $_from;
	private $_day_count;
	public function __construct($name, $day_value)
	{
		$this->_name = $name;
        $add = [];
        $add["min"] = "0";
        $add["id"] = $name;
		$this->_day_count = new InputBase("number", $name, abs($day_value), "", $add);
	}
	
	private function view_radio(string $text, bool $check)
	{
        $name = $this->_name."_select[]";
		if($check){
			echo "<input type='radio' name='$name' value='$text' checked>$text"; 
		}else{
			echo "<input type='radio' name='$name' value='$text'>$text"; 
		}
	}

	public function view(Param $p)
	{
        $value = $p->get_value();

	?>
		<div class='setting_input_div_name'>
            <div class='day_num_area'>
                <?php $this->_day_count->view(); ?>
                <div>
                    <?php
                    $checked = (empty($value) || $value <= 0);
                    $this->view_radio("日前", $checked);
                    ?>
                    <br>
                    <?php
                    $checked = $value > 0;
                    $this->view_radio("日後", $checked);
                    ?>
                </div>
             </div>
		</div>
	<?php
	}

	public function get_day_num() : string
	{
		return $this->_day_count->get_value();
	}
	
}

?>