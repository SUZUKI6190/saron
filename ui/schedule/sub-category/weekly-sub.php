<?php
namespace ui\schedule;
use \business\entity\WeeklyYoyaku;

use ui\frame\ManageFrameContext;
use \business\facade;

use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\scheule\ScheduleContext;

class WeeklySub extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	
	private function view_week(WeeklyYoyaku $w)
	{
		?>
		
		<?php
	}
	
	public function view()
	{
		?>
		
		<table>
		</table>
		
		<?php
	}
	
	public function get_name()
	{
		return "day_of_the_week";
	}
	
	public function get_title_name()
	{
		return "曜日ごとの設定";
	}
	
}

?>