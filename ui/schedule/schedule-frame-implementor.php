<?php
namespace ui\schedule;
require_once('schedule-context.php');
require_once('sub-category/schedule-view-sub.php');
require_once('sub-category/weekly-sub.php');
require_once(dirname(__FILE__).'/../../business/facade/schedule.php');
require_once(dirname(__FILE__).'/../../business/entity/schedule.php');
use \ui\frame\ManageFrameImplementor;
use ui\frame\HeaderFile;

class ScheduleFrameImplementor extends ManageFrameImplementor
{
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new WeeklySub());

		return $ret;
	}

	public function view_main()
	{
		
	}
	
	protected function get_css_list()
	{
		return [
			new HeaderFile('schedule.css', 1.0)
		];
	}
	
	protected function get_js_list()
	{
		return [
			
		];
	}
	
}

?>