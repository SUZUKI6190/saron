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
                    new FlowOtherDetailNew()
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