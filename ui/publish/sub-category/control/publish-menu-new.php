<?php
namespace ui\publish;
require_once('publish-menu.php');
use \business\entity\Menu;
use \business\entity\MenuCourse;
class ViewMenuDetailNew extends ViewMenuDetail
{
	public function save_inner(Menu $menu)
	{
		\business\facade\insert_menu($menu);
	}
	
	protected function get_default_menu(): Menu
	{
		return Menu::get_empty_object();
	}
}

?>