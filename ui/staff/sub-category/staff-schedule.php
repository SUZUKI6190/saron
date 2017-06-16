<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule-table-param.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputBase;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;

class StaffShceduleSub extends \ui\frame\SubCategory
{
    private $_staff_list;
    private $_selected_staff_id;
    private $_param_list;
    const staff_select_btn_name = "staff_select_btn";
    const staff_select_id = "staff_select_id";
    const date_name = "date_name";

	public function init()
	{
		$context = StaffContext::get_instance();
        $this->_staff_list = \business\facade\get_staff_all();
        if($this->is_select_staff())
        {
            $this->_selected_staff_id = $this->get_selected_staff_id();
            $this->_param_list = \business\facade\select_yoyaku_registration_by_staffid($this->_selected_staff_id);
        }
	}

    private function is_select_staff():bool
    {
        return isset($_POST[self::staff_select_btn_name]);
    }

    private function get_selected_staff_id():string
    {
        return $_POST[self::staff_select_id];
    }


	public function view()
	{
        ?>
        <form method="post" action="">
            <div class="wrap">
            <?php
                $this->view_staff_list();
            ?>
            </div>
        </form>
        <?php
	}

    private function view_staff_list()
    {
        $name = self::staff_select_id;
        ?>
        <div class='staff_select_area'>
            <span>日にち：</span>
            <input type='date' name='<?php echo self::date_name; ?>' /><br>
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
            <button class="manage_button" type="submit" name='<?php echo self::staff_select_btn_name; ?>'>表示する</button>
        </div>
        <div class='time_schedule_table_area'>
            <?php $this->view_time_schedule_table(); ?>
        </div>
        <?php
    }

    private function view_time_schedule_table()
    {
        $date = new \DateTime('9:00');
        $max_time = new \DateTime('21:00');
        $interval = new \DateInterval('P0DT30M');
        ?>
        <table class='time_schedule_table'>
        <?php
        while($date < $max_time)
        {
            $time = $date->format('H:i');
            ?>
            <tr>
                <th>
                    <?php echo $time; ?>
                </th>
                <td>
                </td>
            </tr>
            <?php
            $date->add($interval);
        }
        ?>
        </table>
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