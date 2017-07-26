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

class ScheduleEdit extends ScheduleBase
{
    private $_name_input, $_date_input, $_time_input;
    private $_schedule_id_input;
    private $_selected_schedule_id;
    private $_delete_btn;
    private function get_edit_value() : string
    {
        return $_POST[StaffShceduleSub::edit_btn_name];
    }

    public function __construct()
    {
        $this->_name_input = new InputControll("text", StaffShceduleSub::schedule_name);
        $this->_date_input = new InputControll("date", StaffShceduleSub::schedule_date);
        $this->_time_input = new InputControll("time", StaffShceduleSub::schedule_time);
        $this->_minutes_input = new InputControll("number", StaffShceduleSub::schedule_minutes);
        $this->_schedule_id_input = new InputControll("hidden", StaffShceduleSub::schedule_id);
        $this->_delete_btn = new ConfirmSubmitButton('delete_schedule_btn', '削除', '', '本当に削除しますか？');
    }

    public function update()
    {
        if($this->is_update_schedule_btn_click()){
            $new_schedule = new Schedule();
            $new_schedule->id = $this->_schedule_id_input->get_value();
            $new_schedule->name = $this->_name_input->get_value();
            $datetime = $this->_date_input->get_value()." ".$this->_time_input->get_value();
            $new_schedule->start_time = $datetime;
            $new_schedule->minutes = $this->_minutes_input->get_value();
            \business\facade\update_schedule($new_schedule);
        }

        if($this->_delete_btn->is_submit()){
            $schedule_id = $this->_schedule_id_input->get_value();
            $schedule = \business\facade\get_schedule_by_id($schedule_id);
            if($schedule->is_yoyaku_schedule()){
                $regist_id = $schedule->extend_data;
                \business\facade\delete_yoyaku_registration_byid($regist_id);
                \business\facade\delete_reserved_course_by_registration_id($regist_id);
            }
            \business\facade\delete_schedule_by_id($schedule_id);
        }
    }

    protected function init_inner()
    {
    }

    private function is_update_schedule_btn_click() : bool
    {
        return isset($_POST[StaffShceduleSub::update_schedule_btn_name]);
    }

    private function view_update_schedule_btn()
    {
?>
        <button class="manage_button" name='<?php echo StaffShceduleSub::update_schedule_btn_name; ?>'>更新</button>
<?php
    }

    protected function view_inner()
    {
        $this->_selected_schedule_id = $this->get_edit_value();
        $f = array_values(array_filter($this->_schedule_list,function($d){
            return $this->_selected_schedule_id == $d->id;
        }));
        $selected_schedule = $f[0];
        $datetime  = new \DateTime($selected_schedule->start_time);
        $date = $datetime->format("Y-m-d"); 
        $time = $datetime->format("h:s");        
        $this->_name_input->set_value($selected_schedule->name);
        $this->_date_input->set_value($date );
        $this->_time_input->set_value($time);
        $this->_minutes_input->set_value($selected_schedule->minutes);
        
        $this->_minutes_input->set_attribute( [
            "min"=>"0"
        ]);

        ?>
        <div class="update_btn_area">
        <?php
        $this->view_update_schedule_btn();
        $this->_delete_btn->view();
        ?>
        </div>
        <?
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
        $this->_schedule_id_input->set_value($this->_selected_schedule_id);
        $this->_schedule_id_input->view();
        ?>
        <input type="hidden" name="<?php echo StaffShceduleSub::edit_btn_name; ?>" value="<?php echo $this->_selected_schedule_id;?>" >
<?php   
    }
}

?>