<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once('publish-sub-cotegory.php');
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

	public function view_main()
	{
		
	}
}
	


?>