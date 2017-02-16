<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');

class MenuSub extends \ui\frame\SubCategory
{
	public function view()
	{
		
	}
	
	public function get_name()
	{
		return "menu";
	}
	
	public function get_title_name()
	{
		return "メニュー設定";
	}
}

?>