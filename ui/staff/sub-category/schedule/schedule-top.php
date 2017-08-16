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

class ScheduleTop extends ScheduleBase
{

    private $_staff_list;
    private $_selected_staff_id = '';

    protected function update_inner()
    {
    }

    protected function init_inner()
    {
    }     

    public function is_empty():bool
    {
        return true;
    }

    private function view_staff_select()
    {
        $context = StaffContext::get_instance();
        $this->_staff_list = \business\facade\get_staff_all();
        $selected_staff_id = $context->get_selected_staff_id();
        $name = StaffContext::staff_select_id;
        ?>
        <div class='staff_select_area'>
            <span>スタッフ:</span>
            <select name='<?php echo $name; ?>'>
            <?php
            foreach($this->_staff_list as $s)
            {       
                $staff_name = $s->name_last." ".$s->name_first;
                if($selected_staff_id == $s->id){
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

    protected function view_inner()
    {
    ?>
        <div class="wrap">
            <?php
                $this->view_staff_select();
            ?>
        </div>
        <div class="top_btn_area">
            <button class="manage_button" type="submit" name='<?php echo StaffContext::list_btn_name; ?>'>予定一覧</button>
            <button class="manage_button" type="submit" name='<?php echo StaffContext::timetable_btn_name; ?>'>タイムスケジュール表</button>
            <button class="manage_button" type="submit" name='<?php echo StaffContext::new_btn_name; ?>'>新しい予定を追加</button>
        </div> 
    <?php
    }
}

?>