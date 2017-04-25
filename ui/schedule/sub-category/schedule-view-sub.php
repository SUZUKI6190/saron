<?php
namespace ui\schedule;

use ui\frame\ManageFrameContext;
use \business\facade;

use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\scheule\ScheduleContext;

class ScheduleViewSub extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	
	
	public function view()
	{
	}
	
	public function get_name()
	{
		return "view";
	}
	
	public function get_title_name()
	{
		return "表示";
	}
	
}

?>