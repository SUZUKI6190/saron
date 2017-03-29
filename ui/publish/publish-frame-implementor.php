<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once('sub-category/publish-edit-menu.php');
require_once('sub-category/publish-view-menu.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
use \ui\frame\ManageFrameImplementor;
use \ui\publish\MenuSub;
use \ui\publish\MenuNewAddSub;

class PublishFrameImplementor extends ManageFrameImplementor
{
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new MenuSub());
		$set_array(new MenuNewAddSub());
		
		return $ret;
	}
	
	protected function get_css_list()
	{
		return [
		new \ui\frame\HeaderFile('publish_menu.css', 0.06)
		];
	}
	public function view_main()
	{
		
	}
}
	


?>