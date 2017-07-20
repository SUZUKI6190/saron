<?php
namespace ui\sales;
use business\entity\SalesMailSetting;
use business\facade\SalesMailSettingFacade;

class SalesMailEditorNew extends SalesMailEditorBase
{
    protected function init_inner()
    {
        
    }

    protected  function get_text():string
    {
        return '追加するメールアドレス';
    }

    protected function save_inner(SalesMailSetting $data)
    {
        SalesMailSettingFacade::insert($data);
    }

    protected function get_mail():SalesMailSetting
    {
        return new SalesMailSetting();
    }
}
?>