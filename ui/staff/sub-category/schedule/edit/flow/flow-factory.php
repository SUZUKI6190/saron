<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow-other-detail-base.php');
require_once(dirname(__FILE__).'/flow-other-detail-edit.php');

class FlowFactory
{
    private function __construct()
    {

    }

    public static function GetOtherEditFlow()
    {
        $ret = [
            new FlowOtherDetailEdit()
        ];

        return $ret;
    }
}

?>