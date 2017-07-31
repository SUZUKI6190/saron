<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule-select-course.php');
require_once(dirname(__FILE__).'/schedule-detail.php');
require_once(dirname(__FILE__).'/schedule-detail-edit.php');
require_once(dirname(__FILE__).'/schedule-detail-new.php');

use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputControll;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;
use \business\entity\Schedule;
use ui\staff\ScheduleBase;

class ScheduleEdit extends ScheduleBase
{
    private $_param_list;
    private $_inner_schedule_base;
    const select_course_name = "select_course_btn";
 
    private function create_inner_schedule_base() : ScheduleBase
    {

        if($this->is_edit_click()){
            return new ScheduleDetailEdit();
        }

        if($this->is_new_click()){
            return new ScheduleDetailNew();
        }

        if($this->is_select_course()){
            return new ScheduleCourseSelect();
        }

    }

    private function is_new_click() : bool
    {
        return isset($_POST[self::new_btn_name]);
    }

    private function is_select_course():bool
    {
        return isset($_POST[self::select_course_name]);
    }

    protected function update_inner()
    {
        $this->_inner_schedule_base->update();
    }

    protected function init_inner()
    {
        $this->_inner_schedule_base->init($this->schedule_list);
    }

    protected function view_inner()
    {
       $this->_inner_schedule_base->view();
    }
}

?>