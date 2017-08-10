<?php
namespace ui\staff;
use business\entity\Schedule;

abstract class FlowBase
{
    protected abstract function init_inner();
    protected abstract function view_inner();
    protected abstract function save_inner();
    protected $_staff_id;
    protected $_schedule_list;
    protected $_base_schedule_edit;
    protected $_selected_schedule_id;
    private $_flow_id;

    protected function get_selected_schedule_id() : int
    {
        return (int)($_POST[StaffContext::edit_btn_name]);
    }

    protected function get_selected_shcedule(): Schedule
    {
        $this->_selected_schedule_id = $this->get_selected_schedule_id();
        $f = array_values(array_filter($this->_schedule_list,function($d){
            return $this->_selected_schedule_id == $d->id;
        }));
        return $f[0];
    }

    public function init($schedule_list)
    {
        $this->_schedule_list = $schedule_list;
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