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

class ScheduleList extends ScheduleBase
{
    private $_param_list;

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
      

    protected function view_inner()
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
                    <button type='submit' class="manage_button" name="<?php echo StaffShceduleSub::edit_btn_name; ?>" value="<?php echo $p->schedule_id; ?>">編集</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }
}

?>