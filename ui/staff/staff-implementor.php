<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/sub-category/staff-sub-category.php');
require_once(dirname(__FILE__).'/sub-category/staff-schedule.php');
require_once('staff-input-form.php');

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
		$set_array(new StaffShceduleSub());
		return $ret;
	}

	public function view_main()
	{
	}
	
	protected function get_css_list()
	{
		return [
		new \ui\frame\HeaderFile('staff.css', 0.04),
		new \ui\frame\HeaderFile('staff-schedule.css', 0.04)
		];
	}
	
	
	protected function get_js_list()
	{
		return [
		new \ui\frame\HeaderFile('manage-staff.js', 0.04),
		new \ui\frame\HeaderFile('staff-schedule.js', 0.04)
		];
	}
}
	


?>