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
    const minutes_30_px = 30;
    const minutes_px = 30 / self::minutes_30_px;
	public function init()
	{
		$context = StaffContext::get_instance();
        $this->_staff_list = \business\facade\get_staff_all();

        if($this->is_select_staff())
        {
            $this->_selected_staff_id = $this->get_selected_staff_id();
            $regit_list = \business\facade\select_yoyaku_registration_by_staffid($this->_selected_staff_id);
            $this->_param_list = array_map(function($d) {
                return ScheduleTableParam::create_from_yoyaku($d);},
                $regit_list);
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
        $name = self::staff_select_id;
        
        ?>
        <form method="post" action="">
            <div class="wrap">
            <?php
                $this->view_staff_list();
            ?>
            </div>
            <?php
            if($this->is_select_staff()){
            ?>
            <div class='time_schedule_table_area'>
                <?php $this->view_time_schedule_table(); ?>
            </div>
            <?php
            }
            ?>
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

        <?php
    }

    private function _view_time_schedule_table()
    {
        $date = new \DateTime('9:00');
        $max_time = new \DateTime('21:00');
        $interval = new \DateInterval('P0DT30M');
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="360px"  height="2000">
            <?php
            $count = 0;
            while($date < $max_time)
            {
                $time = $date->format('H:i');
                $text_top = 60 * $count;
                
                $time_text = "";
                $line = "";
                ?>
                <g transform='translate(0, <?php echo $text_top; ?>)'>
                    <text font-size='20px' x='0' y='30'><?php echo $time; ?></text>
                    <line x1="0" y1="50" x2="360" y2="50" style="stroke:rgb(0,0,0);stroke-width:1" />
                </g>
                <?php
                $date->add($interval);
                $count++;
            }
            ?>
            <line x1="100" y1="0" x2="100" y2="2000" style="stroke:rgb(0,0,0);stroke-width:1" />
            <rect x="0" y="1" width="360" height="2000" style="fill:none;stroke:black;stroke-width:1;">
        </svg>
        <?php
    }

    private function view_time_schedule_table()
    {
        $date = new \DateTime('9:00');
        $max_time = new \DateTime('21:00');
        $interval = new \DateInterval('P0DT30M');
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
                foreach($this->_param_list as $p)
                {
                    $px = $p->start_time * self::minutes_px;
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