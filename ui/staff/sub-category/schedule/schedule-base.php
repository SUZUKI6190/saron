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
    protected $_staff_id;

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

    protected function view_staff_name_area()
    {
        $context = StaffContext::get_instance();
        $staff = \business\facade\get_staff_byid( $context->get_selected_staff_id());
        $name = $staff->name_first.$staff->name_last;
        ?>
        <div class='staff_name_area'>
        <span>スタッフ名：</span>
        <span><?php echo $name; ?></span>
        </div>
        <?php
    }

    public function view()
    {
        $this->view_staff_name_area();
        $this->view_inner();
    }

    public function set_staff_id($id)
    {
        $this->_staff_id = $id;
    }

}

?>