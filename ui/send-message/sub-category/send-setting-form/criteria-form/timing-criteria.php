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

class LastVisitCriteria extends Criteria
{
    private $_last_visit;
  
    public function init_inner()
    {
        $param = $this->get_context_param();
        $this->name= $param->get_key();
        $this->_last_visit = new DayCriteriaForm($param->get_key(), $this->default_msg->last_visit);
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }
    
    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->last_visit;
    }

    public function get_title():string
    {
        return "最終来店日";
    }

    public function view()
    {
        $param = $this->get_context_param();
        $this->_last_visit->view($param, $this->is_hidden());
    }

}

class NextVisitCriteria extends Criteria
{
    private $_next_visit;
 
    public function init_inner()
    {
        $param = $this->get_context_param();
        $this->name= $param->get_key();
        $this->_next_visit = new DayCriteriaForm($param->get_key(), $this->default_msg->next_visit);
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
   }

    public function get_title():string
    {
        return "次回来店予定日";
    }

    public function view()
    {
        $this->_next_visit->view($this->get_context_param(), $this->is_hidden());       
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->next_visit;
    }

}

class BirthVisitCriteria extends Criteria
{
    private $_birth;

    public function get_title():string
    {
        return "誕生日";
    }

    public  function update_mseeage(SendMessage $s)
    {
        $param = $this->get_context_param();
    	$param->clear();
    }

    public function init_inner()
    {
        $param = $this->get_context_param();
        $this->name= $param->get_key();
        $this->_birth= new DayCriteriaForm($param->get_key(), $this->default_msg->birth);
    }

    public function get_context_param():param
    {
        return SendMessageContext::get_instance()->get_param_set()->birth;
    }

    public function view()
    {
        $param = $this->get_context_param();
        $this->_birth->view($param, $this->is_hidden());
    }

}


class DayCriteriaForm
{
	private $_name;
	private $_from;
	private $_day_count;
    private $_day_value;
	public function __construct($name, $day_value)
	{
		$this->_name = $name;
        $add = [];
        $add["min"] = "0";
        $add["id"] = $name;
        $this->_day_value = $day_value;
		$this->_day_count = new InputControll("number", $name);
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

	public function view(Param $p, bool $disabled)
	{
        $add = [];
        $add["min"] = "0";
        $add["id"] = $this->_name;
        $value = $p->get_value();
        $this->_day_count->set_value(abs($this->_day_value));
        $this->_day_count->set_attribute($add);
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