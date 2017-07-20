<?php
namespace ui\sales;
use business\entity\SalesMailSetting;
use business\facade\SalesMailSettingFacade;

class SalesMailEditorEdit extends SalesMailEditorBase
{
    protected function init_inner()
    {

    }

    protected  function get_text():string
    {
        return '変更するメールアドレス';
    }

    protected function get_page_value():string
    {
        return SalesMailContext::EditKeyValue;
    }

    protected function save_inner(SalesMailSetting $data)
    {
        SalesMailSettingFacade::update($data);
    }

    protected function get_mail():SalesMailSetting
    {
        $id = $this->get_edit_sales_id();
        return SalesMailSettingFacade::get_by_id($id);
    }
    
}
?>