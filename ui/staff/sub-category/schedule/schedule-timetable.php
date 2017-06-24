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

class ScheduleTimeTable extends ScheduleBase
{
    private $_param_list;
    const date_name = "date_name";
    const minutes_30_px = 30;
    const minutes_px = 30 / self::minutes_30_px;

    protected function update_inner()
    {
    }

    protected function init_inner()
    {
        $this->_param_list = array_map(
            function($d) {
                    return ScheduleTableParam::create_from_yoyaku($d);
                },
                $this->_schedule_list
            );
    }

    private function view_update_btn()
    {
?>
        <button class="manage_button" name='<?php echo StaffShceduleSub::update_btn_name; ?>'>更新する</button>
<?php
    }

    private function get_selected_date()
    {
        if(isset($_POST[StaffShceduleSub::date_name])){
            return $_POST[StaffShceduleSub::date_name];
        }else{
            return "";
        }
    }

    private function is_update_click() : bool
    {
         return isset($_POST[StaffShceduleSub::update_btn_name]);
    }

    protected function view_inner()
    {
        $date = new \DateTime('9:00');
        $max_time = new \DateTime('21:00');
        $interval = new \DateInterval('P0DT30M');
        ?>
        <span>日時選択：</span>
        <?php
        $date_value = "";
        if($this->is_update_click()){
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
}

?>