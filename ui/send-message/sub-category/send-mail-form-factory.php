<?php

function SendingFormFactory() :SettingForm
{
    $sf;
    if(!isset($_POST[SettingForm::SendMailSettingKey])){
        $sf = new ContentSetting();
    }else{
        $parm = $_POST[SettingForm::SendMailSettingKey];

        switch($param)
        {
            case SettingForm::TimingKey:
                break;
            case SettingForm::CustomerKey:
                break;
        }
    }

    return $sf;
}

?>