<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow-other-detail-base.php');
require_once(dirname(__FILE__).'/flow-other-detail-edit.php');
require_once(dirname(__FILE__).'/flow-other-detail-new.php');

use ui\staff\StaffContext;

class FlowFactory
{
    private function __construct()
    {

    }

    public static function GetEditFlow()
    {
        $ret = [
            new FlowOtherDetailEdit()
        ];

        return $ret;
    }

    public static function GetOtherNewFlow()
    {
        $ret = [
            new FlowOtherDetailNew()
        ];

        return $ret;
    }
}

?>