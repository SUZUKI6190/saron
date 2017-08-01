<?php
namespace ui\staff;

abstract class FlowBase
{
    protected abstract function init_inner();
    protected abstract function view_inner();
    protected abstract function save_inner();
    protected $_schedule_list;
    public function init($schedule_list)
    {
        $this->_schedule_list = $schedule_list;
        $this->init_inner();
    }

    public function view()
    {
        $this->view_inner();
    }

    public function save()
    {
        $this->save_inner();
    }
      
}

?>