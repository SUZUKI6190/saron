<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/send-setting-form/setting-form.php');
require_once(dirname(__FILE__).'/send-setting-form/customer-criteria-setting.php');
require_once(dirname(__FILE__).'/send-setting-form/timing-criteria-setting.php');
require_once(dirname(__FILE__).'/send-setting-form/content-setting.php');

use ui\send_message\SendMessageContext;

function SettingFormFactory() :SettingForm
{
    $sc = SendMessageContext::get_instance();
    $page_no = (int)$sc->get_page_no();

    $form_list = [
        function () { return new ContentSetting();},
        function () { return new TimingCriteriaSetting();},
        function () { return new CustomerCriteriaSetting();}
    ];   

    return $form_list[$page_no]();
}

?>