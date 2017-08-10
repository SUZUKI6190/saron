<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow/flow-base.php');
require_once(dirname(__FILE__).'/flow/flow-factory.php');
require_once(dirname(__FILE__).'/flow/flow-save-base.php');
require_once(dirname(__FILE__).'/flow/flow-save-factory.php');

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
    private $_flow_list;
    private $_current_flow;
	private $pre_page_no;
    private $current_page_no;
    private $_flow_id;

    const select_course_name = "select_course_btn";
 
    const PrePageNoName = 'pre_flow_no_name';

    public function __construct($flow_id)
    {
        $this->_flow_id = $flow_id;
        $this->pre_page_no = $this->get_pre_page_no();
        $this->current_page_no = $this->get_current_page_no();

        $this->_flow_list = FlowFactory::GetEditFlow($this->_flow_id);
        
        $this->_current_flow = $this->get_current_flow();
        $this->_current_flow->set_base_schedule_edit($this);
        $this->_current_flow->set_flow_id($this->_flow_id);

    }

    protected function init_inner()
    {
        $this->_current_flow->set_staff_id($this->_staff_id);
        $this->_current_flow->init($this->_schedule_list);
    }

    public function update()
    {
        $pre_flow = $this->get_pre_current_flow();
        $pre_flow->set_staff_id($this->_staff_id);
        $pre_flow->save();
        // $this->_flow_save->save();
    }

    private function get_current_flow() : FlowBase
    { 
        return $this->_flow_list[$this->current_page_no];
    }

    private function get_pre_current_flow() : FlowBase
    { 
        return $this->_flow_list[$this->pre_page_no];
    }

    private function get_current_page_no()
    {
        if(isset($_POST[StaffContext::MoveName])){
            return $this->pre_page_no + $_POST[StaffContext::MoveName];
        }else{
            return 0;
        }        
    }

    public function view_next_button($text, $move_value)
    {
        $css = 'manage_button';
        if($move_value == -1){
            if($this->current_page_no == 0){
                $css = 'manage_button hidden_btn';
            }
        }
       if($move_value == 1){
            if($this->current_page_no == count($this->_flow_list) - 1){
                $css = 'manage_button hidden_btn';
            }
        }
        ?>
        <button class='<?php echo $css; ?>' name='<?php echo StaffContext::MoveName; ?>' value='<?php echo $move_value; ?>'><?php echo $text; ?></button>       
        <?php
    }

    private function get_pre_page_no()
    {
        if(isset($_POST[self::PrePageNoName])){
            return $_POST[self::PrePageNoName];
        }else{
            return 0;
        }
    }

    private function view_move_button() : bool
    {
        return count($this->_flow_list) > 1;
    }

    private function view_save_button()
    {
        $filter = array_values(array_filter($this->_flow_list, function($f){
            return !$f->enable_save();
        }));

        if(count($filter) == 0){
            $save_name = StaffContext::update_schedule_btn_name;
            echo "<div class='schedule_save_btn_area'><button class='manage_button' type='submit' name='$save_name'>保存</button></div>";
        }
    }

    protected function view_inner()
    {
        $this->view_save_button();
        if($this->view_move_button()){
        ?>
            <div class='move_btn_area'>
                <?php $this->view_next_button('前へ', -1); ?>
                <?php $this->view_next_button('次へ', 1); ?>
            </div>
        <?php
        }
        $this->_current_flow->view();
        ?>
        <input type='hidden' name='<?php echo StaffContext::edit_page_name; ?>' value=''>
        <input type='hidden' name='<?php echo self::PrePageNoName; ?>' value='<?php echo $this->current_page_no; ?>'>
        <?php
    }
}

?>