<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule-table-param.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputControll;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;

class StaffShceduleSub extends \ui\frame\SubCategory
{
    private $_staff_list;
    private $_selected_staff_id;
    private $_param_list;
    private $_schedule_list;
    const staff_select_btn_name = "staff_select_btn";
    const staff_select_id = "staff_select_id";
    const list_btn_name = "list_btn";
    const timetable_btn_name = "time_table_btn";
    const edit_btn_name = "edit_btn";
    const date_name = "date_name";
    const minutes_30_px = 30;
    const minutes_px = 30 / self::minutes_30_px;

    const schedule_name = "schedule_name";
    const schedule_date = "schedule_date";
    const schedule_minutes = "schedule_minutes";
    const schedule_time = "schedule_time";

    private $_name_input, $_date_input, $_time_input;

	public function init()
	{
		$context = StaffContext::get_instance();
        $this->_staff_list = \business\facade\get_staff_all();

        $this->_name_input = new InputControll("text", self::schedule_name);
        $this->_date_input = new InputControll("date", self::schedule_date);
        $this->_time_input = new InputControll("time", self::schedule_time);
        $this->_minutes_input = new InputControll("number", self::schedule_minutes);

        if($this->is_select_staff())
        {
            $this->_selected_staff_id = $this->get_selected_staff_id();

            $this->_schedule_list = \business\facade\get_schedule_by_staffid($this->_selected_staff_id);
            
            $this->_param_list = array_map(
                function($d) {
                    return ScheduleTableParam::create_from_yoyaku($d);
                },
                $this->_schedule_list
            );
        }
	}

    private function is_select_staff() : bool
    {
        return $this->is_timetable_click() || $this->is_list_click() || $this->is_edit_click(); 
    }

    private function get_selected_staff_id() : string
    {
        return $_POST[self::staff_select_id];
    }

    private function is_edit_click() : bool
    {
        return isset($_POST[self::edit_btn_name]);
    }

    private function get_edit_value() : string
    {
        return $_POST[self::edit_btn_name];
    }

    private function get_selected_date()
    {
        if(isset($_POST[self::date_name])){
            return $_POST[self::date_name];
        }else{
            return "";
        }
    }

    public function is_timetable_click():bool
    {
        return isset($_POST[self::timetable_btn_name]) || isset($_POST[self::staff_select_btn_name]);
    }

    public function is_list_click():bool
    {
        return isset($_POST[self::list_btn_name]);
    }

    private function view_update_btn()
    {
?>
        <button name='<?php echo self::staff_select_btn_name; ?>'>更新する</button>
<?php
    }

	public function view()
	{
        $name = self::staff_select_id;
        $d = "?date=".(new \DateTime())->format("Ymdhis");
        ?>
        <form method="post" action='<?php echo "$d" ?>'>
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
                if($this->is_timetable_click()){
                    $this->view_time_schedule_table();
                }
                if($this->is_list_click()){
                    $this->view_schedule_list();
                }

                if($this->is_edit_click()){
                    $this->view_edit();
                }
            ?>
            </div>
        </form>
        <?php
	}

    private function view_edit()
    {
        $selected_schedule_id = $this->get_edit_value();
        $selected_schedule;
        foreach($this->_schedule_list as $p)
        {
            if($selected_schedule_id == $p->id)
            {
                $selected_schedule = $p;
            }
        }
        $datetime  = new \DateTime($selected_schedule->start_time);
        $date = $datetime->format("Y-m-d"); 
        $time = $datetime->format("h:s"); 
        $this->view_update_btn();
        
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
        <?php $this->_minutes_input->view() ?>
        
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

    private function view_schedule_list()
    {
        if(count($this->_param_list )== 0)
        {
            return;
        }
        ?>
        <table class='schedule_list'>
         <thead>
            <th>
                予定名
            </th>
            <th>
                お客様名
            </th>
            <th>
                開始日時
            </th>
            <th>
                所要時間
            </th>
            <th>
            </th>
        </thead>
        <?php
        foreach($this->_param_list as $p)
        {
            ?>
            <tr>
                <td>
                <?php
                    echo $p->schedule_name;
                ?>
                </td>
                <td>
                <?php
                    echo $p->customer_name;
                ?>
                </td>
                <td>
                <?php
                    echo $p->start_datetime;
                ?>
                </td>
                <td>
                <?php
                    echo $p->minites_len;
                ?>
                </td>
                <td>
                    <button type='submit' name="<?php echo self::edit_btn_name; ?>" value="<?php echo $p->schedule_id; ?>">編集</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }

    private function view_time_schedule_table()
    {
        $date = new \DateTime('9:00');
        $max_time = new \DateTime('21:00');
        $interval = new \DateInterval('P0DT30M');
        ?>
        <span>日時選択：</span>
        <?php
        $date_value = "";
        if($this->is_select_staff()){
            $date_value =  "value = '".$this->get_selected_date()."'";
        }
        ?>
        <input type='date' name='<?php echo self::date_name; ?>' <?php echo  $date_value; ?> />
        <?php
        $this->view_update_btn();
        ?>
        <div class='time_schedule_table'>
            <div class='time_col'>
                <?php
                while($date < $max_time)
                {
                    $time = $date->format('H:i');
                    ?>
                    <div class='time_area'>
                        <div class='time_cell'><?php echo $time; ?></div>
                    </div>
                    <?php
                    $date->add($interval);
                }
                ?>
            </div>
            <div class='schedule_col'>
                <?php
                
                $selected_date = (new \DateTime($this->get_selected_date()))->format("Ymd");

                foreach($this->_param_list as $p)
                {
                    if($selected_date != (new \DateTime($p->start_datetime))->format("Ymd"))
                    {
                        continue;
                    }
                    $px = $p->start_minutes * self::minutes_px;
                    $px = $px + $px / self::minutes_30_px;
                    $height = $p->minites_len;
                    ?>                   
                    <div class='schedule_cell' style='height:<?php echo $height; ?>px;top:<?php echo $px; ?>px;'>
                        <span class='yoyaku_name'>
                            <?php echo $p->schedule_name; ?>
                        </span>
                        <span class='customer_name'>
                            <?php echo $p->customer_name; ?> 様
                        </span>
                    </div>
                    <?php
                }
                
                ?>
            </div>
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