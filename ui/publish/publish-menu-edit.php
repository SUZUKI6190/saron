<?php
namespace ui\publish;
require_once('publish-menu.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
use \business\entity\Menu;
use \business\entity\MenuCourse;
class ViewMenuDetailEdit extends ViewMenuDetail
{
	public function save_inner(Menu $menu)
	{
		
	}
}

?>