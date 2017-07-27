<?php
namespace business\entity;

class Schedule
{
	public $id;
	public $staff_id;
	public $start_time;
	public $minutes = 0;
	public $schedule_division;
	public $name = '';
	public $extend_data;
	const Yoyaku = 0;
	const Holyday = 1;
	const Other = 99;

	public static function CreateObjectFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->staff_id = $wpdb->staff_id;
		$ret->start_time = $wpdb->start_time;
		$ret->minutes = $wpdb->minutes;
		$ret->schedule_division = $wpdb->schedule_division;
		$ret->name = $wpdb->name;
		$ret->extend_data = $wpdb->extend_data;
		return $ret;
	}

	private function check_schedule_div($id):bool
	{
		return $this->schedule_division == $id;
	}

	public function is_yoyaku_schedule():bool
	{
		return $this->check_schedule_div(self::Yoyaku);
	}
}

?>