<?php
namespace ui\schedule;
use \business\entity\WeeklyYoyaku;

use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\InputBase;
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
		$ret->from_time = "09:00";
		$ret->to_time = "19:00";
		$ret->is_regular_holiday = 0;

		return $ret;
	}
}

class WeekInputForm
{
	public $_week_char;
	private $_from_time;
	private $_to_time;
	private $_is_regular_holiday;

	public function __construct(WeekData $w)
	{
		$this->_from_time = new InputBase('time', $w->char.'_from_time', $w->from_time, "");
		$this->_to_time = new InputBase('time', $w->char.'_to_time', $w->from_time, "");
		
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
	
	private function view_week(WeekData $w)
	{
		?>
			<div class='week_area'>
				<div class='week_char'>
					<?php echo $w->week_char; ?>
				</div>
				</br>
				<div class='frome_time'>
					<span>開始</span>
					<input type='time' name='from_ttime' value="<?php echo $w->from_time; ?>" />
				</div>
				<div class='to_time'>
					<span>終了</span>
					<input type='time' value="<?php echo $w->to_time; ?>" />
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

			$this->view_week($d);
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