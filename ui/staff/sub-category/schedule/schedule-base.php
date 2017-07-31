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

abstract class ScheduleBase
{
    protected abstract function init_inner();
    protected abstract function view_inner();
    protected $_schedule_list;
    public function init($schedule_list)
    {
        $this->_schedule_list = $schedule_list;
        $this->init_inner();
    }

    public function is_empty():bool
    {
        return false;   
    }

    public function update()
    {
        
    }

    public function view()
    {
        $this->view_inner();
    }
}

?>