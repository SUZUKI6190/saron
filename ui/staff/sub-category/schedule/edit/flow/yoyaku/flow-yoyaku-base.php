<?php
namespace ui\staff;

abstract class FlowYoyakuBase extends FlowBase
{
    public function __construct()
    {
        $fc = FlowYoyakuContext::get_instance();
        $fc->init();
    }

}

?>