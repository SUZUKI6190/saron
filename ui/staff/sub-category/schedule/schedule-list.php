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
    private $_view_func;
    const checked_list_name = "checked_schedule";
    const delete_schedule_id_list = "delete_schedule_id_list";

    public function __construct()
    {
        if(isset($_POST[self::checked_list_name])){

            $this->_view_func = function(){
                $this->view_delete();
            };

        }else{

            if(isset($_POST[StaffContext::delete_confirm_btn_name])){
                $checked_list = explode(",",$_POST[self::delete_schedule_id_list]);

                foreach($checked_list as $c){
                    StaffScheduleFacade::delete_by_id($c);
                }
            }

            $this->_view_func = function(){
                $this->view_list();
            };

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
        call_user_func($this->_view_func);
    }

    private function view_delete()
    {
        ?>
        <div class='delete_btn_area'>
            <button type='submit' class="manage_button list_button" name='<?php echo StaffContext::delete_confirm_btn_name; ?>' value="<?php echo $p->schedule_id; ?>">削除</button>
        </div>
        <span>以下のスケジュールを削除します。</span>
        <table class='deleat_schedule_list_table'>
            <thead>
                <tr>
                    <th>
                    スケジュール名
                    </th>
                </tr>
            </thead>
            <?php
            foreach($this->_schedule_list as $s)
            {?>
            <tr>
                <td>
                    <?php echo $s->name; ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
        <input type='hidden' name='<?php echo self::delete_schedule_id_list; ?>' value=<?php echo implode(',', $_POST[self::checked_list_name]); ?> />
        <?php
    }

    private function view_list()
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
