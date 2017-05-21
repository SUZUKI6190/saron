<?php
namespace ui\send_message\sub_category;

function SendingFormFactory() :SettingForm
{
    $sf;
    if(!isset($_POST[SettingForm::SendMailSettingKey])){
        $sf = new ContentSetting();
    }else{
        $parm = $_POST[SettingForm::SendMailSettingKey];

        switch($param)
        {
            case TimingCriteriaSetting::Key:
                $sf = new TimingCriteriaSetting();
                break;
            case CustomerCriteriaSetting::Key:
                $sf = new CustomerCriteriaSetting();
                break;
        }
    }

    return $sf;
}

?>