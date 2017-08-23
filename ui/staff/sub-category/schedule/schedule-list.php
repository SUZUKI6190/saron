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
use \business\facade\StaffScheduleFacade;

class ScheduleList extends ScheduleBase
{
    private $_param_list = [];
    const checked_list_name = "checked_schedule";

    public function __construct()
    {
        if(isset($_POST[self::checked_list_name])){
            $checked_list = $_POST[self::checked_list_name];
            foreach($checked_list as $c){
                StaffScheduleFacade::delete_by_id($c);
            }
        }
    }

    protected function update_inner()
    {
    }

    protected function init_inner()
    {

        if(count($this->_schedule_list) < 1){
            return;
        }

        $this->_param_list = array_map(
            function($d) {
                    return ScheduleTableParam::create_from_schedule($d);
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
        <div class='delete_btn_area'>
            <button type='submit' class="manage_button list_button" name='<?php echo StaffContext::delete_btn_name; ?>' value="<?php echo $p->schedule_id; ?>">チェックされた予定を削除</button>
        </div>
        <table class='schedule_list'>
         <thead>
            <th></th>
            <th>
                予定名
            </th>
            <th>
                開始日時
            </th>
            <th>
                時間
            </th>
            <th>
                種別
            </th>
            <th></th>
        </thead>
        <?php
        $chech_box_name = self::checked_list_name."[]";
        foreach($this->_param_list as $p)
        {
            ?>
            <tr>
                <td>
                    <input type='checkbox' value="<?php echo $p->schedule_id; ?>" name='<?php echo $chech_box_name; ?>'>
                </td>
                <td>
                <?php
                    echo $p->schedule_name;
                ?>
                </td>
                <!-- <td>
                <?php
                    // echo $p->customer_name;
                ?>
                </td> -->
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
                <?php
                    if($p->schedule_division == Schedule::Yoyaku){
                        echo '予約';
                    }else{
                        echo 'その他';
                    }
                ?>
                </td>
                <td class='button_td'>
                    <button type='submit' class="manage_button list_button" name="<?php echo StaffContext::edit_btn_name; ?>" value="<?php echo $p->schedule_id; ?>">編集</button>
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