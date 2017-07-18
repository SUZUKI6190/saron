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
    {

    }

    public static function create_viewer() : ISalesMailViewer
    {

    }
}

?>