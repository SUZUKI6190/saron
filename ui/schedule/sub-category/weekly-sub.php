<?php
namespace ui\schedule;
use \business\entity\WeeklyYoyaku;

use ui\frame\ManageFrameContext;
use \business\facade;

use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\scheule\ScheduleContext;

class WeekData
{
	public $week_char="";
	public $from_time;
	public $to_time;
	public $is_regular_holiday;
	
	public static function create_by_weelyyoyaku(WeeklyYoyaku $w) : WeekData
	{
		$ret = new WeekData();
		$ret->week_char = $w->get_week_char();
		$ret->from_time = $w->from_time;
		$ret->to_time = $w->to_time;
		$ret->is_regular_holiday = $w->is_regular_holiday;
		
		return $ret;
	}
	
	public static function get_default_data($week_char): WeekData
	{
		$ret = new WeekData();
		$ret->week_char = $week_char;
		$ret->from_time = "9:00";
		$ret->to_time = "19:00";
		$ret->is_regular_holiday = 0;

		return $ret;
	}
}

class WeeklySub extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	private $_weekly_list;
	const week_list = ['日','月','火','水','木','金','土'];
	public function __construct()
	{		
		$this->_weekly_list = \business\facade\get_weekly_data();
	}
	
	private function view_week(WeeklyYoyaku $w)
	{
		?>
			<div class='week_area'>
				<div class=''>
				
				</div>
			</div>
		<?php
	}
	
	public function view()
	{
		foreach(self::week_list as $w)
		{
			$d;
			if(array_key_exists($w, $this->_weekly_list)) {
				$d = WeekData::create_by_weelyyoyaku($this->_weekly_list[$w]);
			}else{
				$d = WeekData::get_default_data($w);
			}
		}
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