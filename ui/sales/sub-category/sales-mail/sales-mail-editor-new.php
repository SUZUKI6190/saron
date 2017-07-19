<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailEditorNew extends SalesMailEditorBase
{
    protected function init_inner()
    {
        
    }

    protected  function get_text():string
    {
        return '追加するメールアドレス';
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