<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule-table-param.php');
require_once(dirname(__FILE__).'/schedule/schedule-base.php');
require_once(dirname(__FILE__).'/schedule/schedule-list.php');
require_once(dirname(__FILE__).'/schedule/schedule-timetable.php');
require_once(dirname(__FILE__).'/schedule/schedule-empty.php');
require_once(dirname(__FILE__).'/schedule/edit/schedule-edit.php');

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
    private $_staff_list;
    private $_selected_staff_id;
    private $_param_list;
    private $_schedule_list;
    const update_btn_name = "update_btn";
    const update_schedule_btn_name = "update_schedule_btn";
    const staff_select_id = "staff_select_id";
    const list_btn_name = "list_btn";
    const timetable_btn_name = "time_table_btn";

    const edit_page_name = 'edit_page_name';
    const new_btn_name = 'new_schedule_btn';
    const edit_btn_name = "edit_btn";
     
    const schedule_name = "schedule_name";
    const schedule_date = "schedule_date";
    const schedule_minutes = "schedule_minutes";
    const schedule_time = "schedule_time";
    const schedule_id = "schedule_id";

    const form_id = "form";

    private $_schedule;
	public function init()
	{
		$context = StaffContext::get_instance();
        $this->_staff_list = \business\facade\get_staff_all();
        $this->_schedule = $this->create_schedule();

        if(!$this->_schedule->is_empty()){
            $this->_schedule->update();

            $this->_selected_staff_id = $this->get_selected_staff_id();

            $this->_schedule_list = \business\facade\get_schedule_by_staffid($this->_selected_staff_id);
            
            $this->_schedule->init($this->_schedule_list);
        }
	}

    private function create_schedule() : ScheduleBase
    {
        if($this->is_timetable_click()){
            return new ScheduleTimeTable();
        }

        if($this->is_list_click()){
            return new ScheduleList();
        }

        if($this->is_edit_page()){
            return new ScheduleEdit();
        }

        return new ScheduleEmpty();
    }

    private function is_edit_page() : bool
    {
        return isset($_POST[self::edit_page_name]) || isset($_POST[self::edit_btn_name]);
    }

    private function get_selected_staff_id() : string
    {
        return $_POST[self::staff_select_id];
    }

    private function is_update_click() : bool
    {
        return isset($_POST[self::update_btn_name]);
    }

    public function is_timetable_click():bool
    {
        return isset($_POST[self::timetable_btn_name]) || $this->is_update_click();
    }

    public function is_list_click():bool
    {
        return isset($_POST[self::list_btn_name]);
    }

    private function view_update_btn()
    {
?>
        <button class="manage_button" name='<?php echo self::update_btn_name; ?>'>更新する</button>
<?php
    }

	public function view()
	{
        $name = self::staff_select_id;
        $d = "?date=".(new \DateTime())->format("Ymdhis");
        ?>
        <form method="post" action='<?php echo "$d" ?>' id='<?php echo self::form_id; ?>'>
            <div class="wrap">
            <?php
                $this->view_staff_select();
            ?>
            <div class="btn_area">
                <button class="manage_button" type="submit" name='<?php echo self::list_btn_name; ?>'>予定一覧</button>
                <button class="manage_button" type="submit" name='<?php echo self::timetable_btn_name; ?>'>タイムスケジュール表</button>
            </div>
            </div>
            <div class='time_schedule_table_area'>
            <?php
                $this->_schedule->view();
            ?>
            </div>
        </form>
        <?php
	}

    private function view_staff_select()
    {
        $name = self::staff_select_id;
        ?>
        <div class='staff_select_area'>
            <span>スタッフ:</span>
            <select name='<?php echo $name; ?>'>
            <?php
            foreach($this->_staff_list as $s)
            {       
                $staff_name = $s->name_last." ".$s->name_first;
                if($this->_selected_staff_id == $s->id){
                    echo "<option value='$s->id' selected>$staff_name";
                }else{
                    echo "<option value='$s->id'>$staff_name";
                }
            }
            ?>
            </select><br>
        </div>
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