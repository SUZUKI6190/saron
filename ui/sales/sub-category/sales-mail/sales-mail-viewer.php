<?php
namespace ui\sales;
interface ISalesMailViewer
{
    public function init();
    public function view();
    public function save();
    public function get_page_no() : int;
}

?>