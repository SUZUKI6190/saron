<?php
namespace ui\staff;
use \business\entity\Staff;
use ui\frame\ManageFrameContext;
use \business\entity\Schedule;
use ui\staff\ScheduleBase;

class FlowMode extends FlowBase
{
  
    protected function init_inner()
    {
        
    }

    protected function enable_save_inner() : bool
    {
        return true;
    }

    protected function view_inner()
    {
        $view_input = function(string $text, int $value, bool $is_checked){
            $checked = '';
            if($is_checked){
                $checked = 'checked';
            }
            ?><input type='radio' name='<?php echo StaffContext::ScheduleTypeName; ?>' value='<?php echo $value; ?>' <?php echo $checked; ?> ><?php
            echo $text;
        }
    ?>
    <div class='schedule_type_wrap'>
        <div class='line'>
            <h2>スケジュールの種類を選択</h2>
            <?php
            $view_input('お客様の予約', Schedule::Yoyaku, true);
            $view_input('その他の予定', Schedule::Other, false);
            ?>
        </div>
    </div>

    <?php        
    }

    protected function save_inner()
    {

    }
}

?>