<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow-other-detail-base.php');
require_once(dirname(__FILE__).'/flow-other-detail-edit.php');
require_once(dirname(__FILE__).'/flow-other-detail-new.php');
require_once(dirname(__FILE__).'/flow-mode.php');
use \business\entity\Schedule;
use ui\staff\StaffContext;

class FlowFactory
{
    private function __construct()
    {

    }

    public static function GetEditFlow()
    {
        if(isset($_POST[StaffContext::new_btn_name])){
            return [
                new FlowMode(),
                new FlowOtherDetailNew()
            ];
        }

        if(isset($_POST[StaffContext::ScheduleTypeName])){
            $value = $_POST[StaffContext::ScheduleTypeName];
            if($value == Schedule::Yoyaku){
                return [
                    new FlowMode(),
                    new FlowOtherDetailEdit()
                ];
            }else{
                return [
                    new FlowMode(),
                    new FlowOtherDetailNew()
                ];
            }
        }

        return [
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