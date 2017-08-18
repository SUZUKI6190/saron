<?php
namespace ui\customer;

interface SearchViewer
{
	public function init();
	public function view();
	public function get_result_message():string;
	public function is_result_message():bool;
}

?>
