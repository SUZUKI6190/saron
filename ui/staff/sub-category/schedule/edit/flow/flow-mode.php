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
        <div class='new_btn_area'>
            <?php $this->_base_schedule_edit->view_next_button('前へ', -1); ?>
            <?php $this->_base_schedule_edit->view_next_button('次へ', 1); ?>
        </div>
        <div class='line'>
            <h2>スケジュールの種類を選択</h2>
            <?php
            $view_input('メニューの予定', Schedule::Yoyaku, true);
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