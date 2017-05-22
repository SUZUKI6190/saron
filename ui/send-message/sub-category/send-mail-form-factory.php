<?php
namespace ui\send_message\sub_category;
use ui\send_message\SendMessageContext;

function SendingFormFactory() :SettingForm
{
    $sc = SendMessageContext::get_instance();
    $page_no = $sc->page_no;
    $sf;
    switch($page_no)
    {
        case 0:
            $sf = new ContentSetting();
            break;
        case 1:
            $sf = new TimingCriteriaSetting();
            break;
        case 2:
            $sf = new CustomerCriteriaSetting();
            break;
    }
    return $sf;
}

?>