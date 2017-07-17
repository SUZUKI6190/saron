<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailEditorNew extends SalesMailEditorBase
{
    protected function init_inner()
    {
        
    }

    protected function get_page_value():string
    {
        return SalesMailContext::NewValueName;
    }

    protected function save_inner(SalesMail $data)
    {
        SalesMailFacade::insert($data);
    }

    protected function get_mail():SalesMail
    {
        return new SalesMail();
    }
}
?>