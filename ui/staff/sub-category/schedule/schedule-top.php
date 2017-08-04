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

    protected function view_inner()
    {
    ?>
        <div class="top_btn_area">
            <button class="manage_button" type="submit" name='<?php echo StaffContext::list_btn_name; ?>'>予定一覧</button>
            <button class="manage_button" type="submit" name='<?php echo StaffContext::timetable_btn_name; ?>'>タイムスケジュール表</button>
            <button class="manage_button" type="submit" name='<?php echo StaffContext::new_btn_name; ?>'>新しい予定を追加</button>
        </div> 
    <?php
    }
}

?>