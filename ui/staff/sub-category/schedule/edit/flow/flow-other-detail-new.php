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

class FlowOtherDetailNew extends FlowOtherDetailBase
{
    private $_selected_schedule_id;
    private $_schedule_id_input;

    protected function get_default_schedule(): Schedule
    {
        $s = new Schedule();
        $s->schedule_division = Schedule::Other;
        return $s;
    }

    protected function update_inner(Schedule $new_schedule)
    {
        \business\facade\insert_schedule($new_schedule);
    }

    protected function get_btn_caption():string
    {
        return "追加";
    }
  
    protected function on_update()
    {

    }

    protected function add_button()
    {
       
    }

    protected function on_view()
    {

    }


}

?>