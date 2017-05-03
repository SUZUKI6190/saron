<?php
namespace ui\schedule;
use \business\entity\WeeklyYoyaku;

use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\InputControll;
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

	public function create_weekly_yoyaku() : WeeklyYoyaku
	{
		$ret = new WeeklyYoyau();
		$ret->week_kbn = $this->week_char;
		$ret->from_time = $this->frome_time;
		$ret->to_time = $this->to_time;
		$ret->is_regular_holiday = $this->is_regular_holiday;
		return $ret;
	}
}

class WeekInputForm
{
	public $_week_char;
	private $_from_time;
	private $_to_time;
	private $_is_regular_holiday;
	const holiday_check_name = 'regular_holiday';
	public function __construct(string $week_char)
	{
		$this->_week_char = $week_char;
		$this->_from_time = new InputControll('time', $week_char.'_from_time');
		$this->_to_time = new InputControll('time', $week_char.'_to_time');
		$this->_is_regular_holiday = new InputControll('checkbox', $week_char."_".self::holiday_check_name);

	}

	public function set_data(WeekData $w)
	{
		$this->_from_time->set_value($w->from_time);
		$this->_to_time->set_value($w->to_time);
		$this->_is_regular_holiday->set_value('holiday');
		$attr = [];
		
		if($w->is_regular_holiday == 1){
			$attr['checked'] = "";
		}
		$this->_is_regular_holiday->set_attribute($attr);
	}

	public function get_from()
	{
		return $this->_from_time->get_value();
	}

	public function get_to()
	{
		return $this->_to_time->get_value();
	}

	public function get_is_regular_holiday()
	{
		return $this->_is_regular_holiday->get_value();		
	}

	public function get_weeklyyoyaku_by_post()
	{
		$ret = new WeeklyYoyaku();
		$ret->week_kbn = $this->_week_char;
		$ret->from_time = $this->_from_time->get_value();
		$ret->to_time = $this->_to_time->get_value();
		if($this->_is_regular_holiday->exist_value())
		{
			$ret->is_regular_holiday = 1;
		}else{
			$ret->is_regular_holiday = 0;
		}
		return $ret;
	}

	public function view()
	{
		?>
			<div class='week_area'>
				<div class='week_char'>
					<?php echo $this->_week_char; ?>
				</div>
				<div class='regular_holiday_area'>
					<span>定休日</span>
					<?php $this->_is_regular_holiday->view(); ?>
				</div>
				</br>
				<div class='frome_time'>
					<span>開始</span>
					<?php $this->_from_time->view(); ?>
				</div>
				<div class='to_time'>
					<span>終了</span>
					<?php $this->_to_time->view(); ?>
				</div>
			</div>
		<?php
	}
}

class WeeklySub extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	private $_weekly_list;
	const week_list = ['0','1','2','3','4','5','6'];
	const week_char = ['月','火','水','木','金','土','日'];
	private $_week_form_list = [];
	private $_save_button;
	public function __construct()
	{		
		$this->_save_button = new SubmitButton('save', '保存する', $this->_form_id);
		
		foreach(self::week_list as $kbn)
		{
			$this->_week_form_list[$kbn] = new WeekInputForm($kbn);
		}

		if($this->_save_button->is_submit())
		{
			\business\facade\delete_weekly_data_all();
			foreach($this->_week_form_list as $w)
			{
				$entity = $w->get_weeklyyoyaku_by_post();
				\business\facade\insert_weekly_data($entity);
			}
		}

		$this->_weekly_list = \business\facade\get_weekly_data();

		foreach(self::week_list as $kbn)
		{
			$d;
			if(array_key_exists($kbn, $this->_weekly_list)) {
				
				$d = WeekData::create_by_weelyyoyaku($this->_weekly_list[$kbn]);
			}else{
				$d = WeekData::get_default_data($kbn);
			}

			$this->_week_form_list[$kbn]->set_data($d);
		}
	}
	
	public function view()
	{
		?>
		<form method='post' id='<?php echo $this->_form_id; ?>' action=''>
		<div class='save_btn_area'>
			<?php $this->_save_button->view(); ?>
		</div>
		<?php
		foreach($this->_week_form_list as $w)
		{
			$w->view();
		}
		?>
		</form>
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