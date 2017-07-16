<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailEditorNew extends SalesMailEditorBase
{
    public function init()
    {

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