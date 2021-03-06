<?php
namespace ui\staff;
use business\entity\Schedule;

abstract class FlowBase
{
    protected abstract function init_inner();
    protected abstract function view_inner();
    protected abstract function save_inner();

    protected $_staff_id;
    protected $_base_schedule_edit;
    protected $_selected_schedule_id;
    protected $_flow_id;

    public function attention_message():string
    {
        return '入力されていない項目があります。';
    }

    protected function get_selected_schedule_id() : int
    {
        return (int)($_POST[StaffContext::edit_btn_name]);
    }

    public function clear_temp_data()
    {

    }

    protected function input_check_inner()
    {
        return true;
    }

    public function input_check() : bool
    {
        return $this->input_check_inner();
    }

    protected function get_selected_shcedule(): Schedule
    {
        $this->_selected_schedule_id = $this->get_selected_schedule_id();
        return \business\facade\get_schedule_by_id($this->_selected_schedule_id);
    }

    public function init()
    {
        $this->init_inner();
    }

    public function set_staff_id($id)
    {
        $this->_staff_id = $id;
    }

    public function set_flow_id($id)
    {
        $this->_flow_id = $id;
    }

    public function set_base_schedule_edit($s)
    {
        $this->_base_schedule_edit = $s;
    }

    private function get_division_name()
    {
        if(isset($_POST[StaffContext::FlowDivisionName])){
            return $_POST[StaffContext::FlowDivisionName];
        }else{
            return '';
        }
    } 

    protected  function enable_save_inner() : bool
    {
        return false;
    }

    public function enable_save() : bool
    {
        return $this->enable_save_inner();
    }

    public function view()
    {
        $this->view_inner();
        $name = StaffContext::FlowDivisionName;
        echo "<input type='hidden' name='$name' value='$this->_flow_id'>";
    }

    public function save()
    {
        $this->save_inner();
    }
      
}

?>