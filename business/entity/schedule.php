<?php
namespace business\entity;

class Schedule
{
	public $id;
	public $staff_id;
	public $start_time;
	public $minutes;
	public $schedule_division;
	public $name;
	public $data;
	const Yoyaku = 0;
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