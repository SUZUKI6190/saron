<?php
namespace ui\sales;
require_once('sales-mail/sales-mail-viewer.php');
require_once('sales-mail/sales-mail-list.php');
require_once('sales-mail/sales-mail-content.php');
require_once('sales-mail/sales-mail-editor-base.php');
require_once('sales-mail/sales-mail-editor-new.php');
require_once('sales-mail/sales-mail-editor-edit.php');
use ui\frame\ManageFrameContext;

class SalesMailViewerFactory
{
    private function __construct()
    {}

    private const key_list = [
        SalesMailContext::NewID,
        SalesMailContext::EditID,
        SalesMailContext::ListID,
        SalesMailContext::ContentID
    ];

    private static function create_viewer_by_id($id = SalesMailContext::ListID) : ISalesMailViewer
    {
        $v;
        switch($id){
            case SalesMailContext::NewID:
                $v = new SalesMailEditorNew();  
                break;
            case SalesMailContext::EditID:
                $v = new SalesMailEditorEdit();
                break; 
            case SalesMailContext::ContentID:
                $v = new SalesMailContent();
                break;
            default:
                $v = new SalesMailList();
                break;
        }
        return $v;
    }

    public static function create_viewer(): ISalesMailViewer
    {
        foreach(self::key_list as $k)
        {
            if(isset($_POST[$k])){
                 
     
                $smc = (SalesContext::get_instance())->sales_mail_context;
                return self::create_viewer_by_id($k);
            }
        }
          return self::create_viewer_by_id();
    }
    
    public static function create_pre_viewer(): ISalesMailViewer
    {
        $smc = (SalesContext::get_instance())->sales_mail_context;
        $id = $smc->get_pre_page_id();
        return self::create_viewer_by_id($id);
    }
}

?>