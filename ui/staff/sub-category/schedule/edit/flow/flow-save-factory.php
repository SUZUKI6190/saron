<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/flow-save/edit-other-save.php');
require_once(dirname(__FILE__).'/flow-save/new-other-save.php');
require_once(dirname(__FILE__).'/flow-save/edit-yoyaku-save.php');
require_once(dirname(__FILE__).'/flow-save/new-yoyaku-save.php');

class FlowSaveFactory
{
    public static function create($flow_id) : FlowSaveBase
    {
        $ret;
        switch($flow_id){
            case StaffContext::EditYoyakuID:
                $ret = new EditYoyakuSave();
                break;
            case StaffContext::EditOtherID:
                $ret = new EditOtherSave();
                break;
            case StaffContext::NewYoyakuID:
                $ret = new NewYoyakuSave();
                break;
            case StaffContext::NewOtherID:
                $ret = new NewOtherSave();
                break;
             default:
                $ret = new DummyFlowSave();
                break;
        }

        return $ret;

    }
}

?>