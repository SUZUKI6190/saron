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

class ScheduleDetailEdit extends ScheduleDetail
{
    private $_selected_schedule_id;
    private $_delete_btn;
    private $_schedule_id_input;

    private function get_edit_value() : string
    {
        return $_POST[StaffShceduleSub::edit_btn_name];
    }

    public function __construct()
    {
        parent::__construct();
        $this->_delete_btn = new ConfirmSubmitButton('delete_schedule_btn', '削除', '', '本当に削除しますか？');
        $this->_schedule_id_input = new InputControll("hidden", StaffShceduleSub::schedule_id);
    }

    protected function get_default_schedule(): Schedule
    {
        $this->_selected_schedule_id = $this->get_edit_value();
        $f = array_values(array_filter($this->_schedule_list,function($d){
            return $this->_selected_schedule_id == $d->id;
        }));
        return $f[0];
    }

    protected function update_inner(Schedule $new_schedule)
    {
        $new_schedule->id = $this->_schedule_id_input->get_value();
        \business\facade\update_schedule($new_schedule);
    }

    protected function on_update()
    {
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

    protected function add_button()
    {
        $this->_delete_btn->view();
    }

    protected function on_view()
    {
        $this->_schedule_id_input->set_value($this->_selected_schedule_id);
        $this->_schedule_id_input->view();
        ?>
        <input type="hidden" name="<?php echo StaffShceduleSub::edit_btn_name; ?>" value="<?php echo $this->_selected_schedule_id;?>" >
        <?php
    }


}

?>