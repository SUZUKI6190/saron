<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
require_once("publish-menu-new.php");
require_once("publish-menu-edit.php");
use \business\facade;

class MenuSub extends \ui\frame\SubCategory
{
	private $_menu_list;
	public function __construct()
	{
		$this->_menu_list = array_map(function($menu){
			return new ViewMenuDetailEdit($menu);
		}, \business\facade\get_menu_list());
	}
	public function view()
	{
		foreach($this->_menu_list as $menu)
		{
			$menu->view();
		}
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