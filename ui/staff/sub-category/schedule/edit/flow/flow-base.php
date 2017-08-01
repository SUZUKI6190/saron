<?php
namespace ui\staff;

abstract class FlowBase
{
    protected abstract function init_inner();
    protected abstract function view_inner();
    protected abstract function save_inner();

    public function init()
    {
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