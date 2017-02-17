<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once("publish-menu-new.php");
require_once("publish-menu-edit.php");
use \business\facade;
use \business\entity\Menu;
use \ui\util\SubmitButton;

class MenuSub extends \ui\frame\SubCategory
{
	private $_menu_list;
	private $_form_id = "menu_form";
	public function __construct()
	{
		$this->_menu_list = array_map(function($menu){
			return new ViewMenuDetailEdit($menu);
		}, \business\facade\get_menu_list());
	}
	public function view()
	{?>
		<div class="input_form">

	<?php
		foreach($this->_menu_list as $menu)
		{
			$menu->view();
		}
	?>
		</div>
	<?php
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

class MenuNewAddSub extends \ui\frame\SubCategory
{
	private $_view_menu_new;
	public function __construct()
	{
		$this->_view_menu_new = new ViewMenuDetailNew(Menu::get_empty_object());
	}
	public function view()
	{
		$this->_view_menu_new->view();
	}

	public function get_name()
	{
		return "addnew";
	}
	
	public function get_title_name()
	{
		return "新しいメニューを追加";
	}
}
?>