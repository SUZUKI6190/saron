<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow/flow-base.php');
require_once(dirname(__FILE__).'/flow/flow-factory.php');

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

    const select_course_name = "select_course_btn";
 
    const MoveName = 'move_next';
    const PrePageNoName = 'pre_flow_no_name';

    protected function init_inner()
    {
        $this->pre_page_no = $this->get_pre_page_no();
        $this->_flow_list = FlowFactory::GetOtherEditFlow();
        $this->_current_flow = $this->get_current_flow();
        $this->_current_flow->init();
    }

    protected function update_inner()
    {
        $this->_current_flow->save();
    }

    private function get_current_flow() : FlowBase
    {
        if(isset($_POST[self::MoveName])){
            $index = $this->pre_page_no + $_POST[self::MoveName];
            return $this->_flow_list[$index];
        }else{
            return $this->_flow_list[0];
        }
    }

    private function get_pre_page_no()
    {
        if(isset($_POST[self::PrePageNoName])){
            return $_POST[self::PrePageNoName];
        }else{
            return '';
        }
    }

    protected function view_inner()
    {
       $this->_current_flow->view();
       ?>
       <input type='hidden' name='<?php echo StaffShceduleSub::edit_page_name; ?>' value=''>
       <input type='hidden' name='<?php echo self::PrePageNoName; ?>' value='<?php echo $this->pre_page_no; ?>'>
       <?php
    }
}

?>