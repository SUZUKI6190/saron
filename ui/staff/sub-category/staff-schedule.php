<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule/schedule-base-factory.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputControll;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;
use \business\entity\Schedule;

class StaffShceduleSub extends \ui\frame\SubCategory
{
    private $_param_list;
    private $_schedule_list;
    private $_schedule;
 
    const schedule_name = "schedule_name";
    const schedule_date = "schedule_date";
    const schedule_minutes = "schedule_minutes";
    const schedule_comment = "schedule_comment";
    const schedule_time = "schedule_time";
    const schedule_id = "schedule_id";

    const form_id = "form";

	public function init()
	{
		$context = StaffContext::get_instance();
        $this->_schedule = ScheduleBaseFactory::create_schedule_base();

        if(!$this->_schedule->is_empty()){
            $selected_staff_id = $context->get_selected_staff_id();

            $this->_schedule_list = \business\facade\get_schedule_by_staffid($selected_staff_id);
         
            $this->_schedule->set_staff_id($selected_staff_id);
   
            $this->_schedule->init($this->_schedule_list);

            $this->_schedule->update();
        }
	}

    private function view_update_btn()
    {
?>
        <button class="manage_button" name='<?php echo StaffContext::update_btn_name; ?>'>更新する</button>
<?php
    }

	public function view()
	{
        $name = StaffContext::staff_select_id;
        $d = "?date=".(new \DateTime())->format("Ymdhis");
        ?>
        <form method="post" action='<?php echo "$d" ?>' id='<?php echo self::form_id; ?>'>
            <div class='time_schedule_table_area'>
            <?php
                 $this->_schedule->view();
            ?>
            </div>
        </form>
        <?php
	}


	public function get_name()
	{
		return "schedule";
	}
	
	public function get_title_name()
	{
		return "スケジュール";
	}
}

?>