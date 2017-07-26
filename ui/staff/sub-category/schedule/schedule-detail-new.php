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

class ScheduleDetailNew extends ScheduleDetail
{
    private $_selected_schedule_id;
    private $_schedule_id_input;

    protected function get_default_schedule(): Schedule
    {
        return new Schedule();
    }

    protected function update_inner(Schedule $new_schedule)
    {
        \business\facade\insert_schedule($new_schedule);
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