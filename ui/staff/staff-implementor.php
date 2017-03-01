<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');

require_once('staff-sub-category.php');
use \ui\frame\ManageFrameImplementor;

class StaffFrameImplementor extends ManageFrameImplementor
{

	public function __construct()
	{

	}
	
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new StaffViewSub());
		$set_array(new StaffAddNewSub());
		return $ret;
	}

	public function view_main()
	{
	}
}
	


?>