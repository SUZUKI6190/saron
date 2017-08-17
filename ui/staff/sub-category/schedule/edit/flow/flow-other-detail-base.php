<?php
namespace ui\staff;

use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputControll;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;
use \business\entity\Schedule;
use ui\staff\ScheduleBase;

abstract class FlowOtherDetailBase extends FlowBase
{
    protected $_name_input, $_date_input, $_time_input, $_minutes_input;
    protected abstract function get_default_schedule(): Schedule;
    protected abstract function update_inner(Schedule $new_schedule);
    protected abstract function on_update();
    protected abstract function add_button();
    protected abstract function on_view();
    protected abstract function get_btn_caption():string;
    
    public function __construct()
    {    
        $this->_name_input = new InputControll("text", StaffShceduleSub::schedule_name);
        $this->_date_input = new InputControll("date", StaffShceduleSub::schedule_date);
        $this->_time_input = new InputControll("time", StaffShceduleSub::schedule_time);
        $this->_minutes_input = new InputControll("number", StaffShceduleSub::schedule_minutes);
    }

    protected function save_inner()
    {
        if($this->is_update_schedule_btn_click()){

            $new_schedule = new Schedule();
            $new_schedule->staff_id = $this->_staff_id;
            $new_schedule->name = $this->_name_input->get_value();
            $datetime = $this->_date_input->get_value()." ".$this->_time_input->get_value();
            $new_schedule->start_time = $datetime;
            $new_schedule->minutes = $this->_minutes_input->get_value();
            $new_schedule->schedule_division = Schedule::Other;
            $this->update_inner($new_schedule);
        }
        
        $this->on_update();
    }

    protected function init_inner()
    {

    }

    private function is_update_schedule_btn_click() : bool
    {
        return isset($_POST[StaffContext::update_btn_name]);
    }


    protected function view_inner()
    {
        $selected_schedule = $this->get_default_schedule();
        $date = "";
        $time = "";
        if(isset($selected_schedule->start_time)){
            $datetime  = new \DateTime($selected_schedule->start_time);
            $date = $datetime->format("Y-m-d"); 
            $time = $datetime->format("H:s");
        }
        $this->_name_input->set_value($selected_schedule->name);
        $this->_date_input->set_value($date );
        $this->_time_input->set_value($time);
        $this->_minutes_input->set_value($selected_schedule->minutes);
        
        $this->_minutes_input->set_attribute( [
            "min"=>"0"
        ]);
?>
        <h2 class='edit_midasi'>
        予定名
        </h2>
        <?php $this->_name_input->view() ?>
        <h2 class='edit_midasi'>
        開始日
        </h2>
        <?php $this->_date_input->view() ?>
        <h2 class='edit_midasi'>
        開始時刻
        </h2>
        <?php $this->_time_input->view() ?>
        <h2 class='edit_midasi' />
        所要時間
        </h2>
        <?php
        $this->_minutes_input->view(); 
        $this->on_view();
    }
}

?>