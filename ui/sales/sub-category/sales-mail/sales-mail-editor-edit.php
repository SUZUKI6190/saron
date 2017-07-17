<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailEditorEdit extends SalesMailEditorBase
{
    protected function init_inner()
    {

    }

    protected function get_page_value():string
    {
        return SalesMailContext::EditKeyValue;
    }

    protected function save_inner(SalesMail $data)
    {
        SalesMailFacade::update($data);
    }

    protected function get_mail():SalesMail
    {
        $sc = SalesContext::get_instance();
        $id = $sc->sales_mail_context->get_edit_sales_id();
        return SalesMailFacade::get_by_id($id);
    }
}
?>