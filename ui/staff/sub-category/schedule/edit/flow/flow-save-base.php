<?php
namespace ui\staff;

abstract class FlowSaveBase
{
    protected abstract function save_inner();

    public function save()
    {
        $this->save_inner();
    }
}

class DummyFlowSave extends FlowSaveBase
{
   protected function save_inner(){}

}

?>