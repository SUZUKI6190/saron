<?php
namespace business\entity;

class WeeklyYoyaku
{
	public $id;
	public $from_time;
	public $to_time;
	public $is_regular_holiday;
	public $week_kbn;
	
	const SunKbn = 0;
	const MonKbn = 1;
	const TueKbn = 2;
	const WedKbn = 3;
	const ThuKbn = 4;
	const FriKbn = 5;
	const SatKbn = 6;
	const HolidayKbn = 7;
	const week_kbn_list = ['月' => 0, '火' => 1, '水' => 2, '木' => 3, '金'=> 4, '土'=> 5, '日' => 6, '祝日'=> 7];
	const week_char_list = ['月', '火', '水', '木', '金', '土', '日', '祝日'];

	public function set_week_kbn_from_char(string $v)
	{
		$this->week_kbn = self::week_kbn_list[$v];
	}

	public function get_week_char():string
	{
		return self:: week_char_list[$this->week_kbn];
	}

	public static function CreateObjectFromWpdb($wpdb) : WeeklyYoyaku
	{
		$ret = new WeeklyYoyaku();
		
		$ret->from_time = $wpdb->from_time;
		$ret->to_time = $wpdb->to_time;
		$ret->is_regular_holiday = $wpdb->is_regular_holiday;
		$ret->week_kbn = $wpdb->week_kbn;
		return $ret;
	}
}

class Schedule
{
	public $id;
	public $staff_id;
	public $start_time;
	public $minutes;
	public $schedule_division;
	public $name;
	public $schdata;

	public static function CreateObjectFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->staff_id = $wpdb->staff_id;
		$ret->start_time = $wpdb->start_time;
		$ret->minutes = $wpdb->minutes;
		$ret->schedule_division = $wpdb->schedule_division;
		$ret->name = $wpdb->name;
		$ret->data = $wpdb->data;
		return $ret;
	}
}

?>