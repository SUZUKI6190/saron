<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/yoyaku/flow-yoyaku-context.php');
require_once(dirname(__FILE__).'/yoyaku/flow-yoyaku-base.php');
require_once(dirname(__FILE__).'/yoyaku/flow-yoyaku-customer.php');
require_once(dirname(__FILE__).'/flow-other-detail-base.php');
require_once(dirname(__FILE__).'/flow-other-detail-edit.php');
require_once(dirname(__FILE__).'/flow-other-detail-new.php');
require_once(dirname(__FILE__).'/flow-mode.php');
require_once(dirname(__FILE__).'/yoyaku/flow-select-course.php');


use \business\entity\Schedule;
use ui\staff\StaffContext;

class FlowFactory
{
    private function __construct(){}

    public static function GetEditFlow($flow_id)
    {
        $ret = [];

        switch($flow_id){
            case StaffContext::EditYoyakuID:
                $ret = [
                    new FlowOtherDetailEdit()
                ];
                break;
            case StaffContext::EditOtherID:
                $ret = [
                    new FlowMode(),
                    new FlowOtherDetailNew()
                ];
                break;
            case StaffContext::NewYoyakuID:
                $ret = [
                    new FlowMode(),
                    new FlowSelectCourse(),
                    new FlowYoyakuCustomer()
                ];
                break;
            case StaffContext::NewOtherID:
                $ret = [
                    new FlowMode(),
                    new FlowOtherDetailNew()
                ];
                break;
        }

        return $ret;
    }

}

?>