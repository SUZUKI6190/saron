<?php
namespace business\entity;

class YoyakuRegistration
{
	public $id;
	public $staff_id;
	public $customer_id;
	public $start_time;
	public $course_id_list;
	public $consultation;
	public static function CreateObjectFromWpdb($wpdb) : YoyakuRegistration
	{
		$ret = new YoyakuRegistration();
		$ret->start_time = $wpdb->start_time;
		$ret->id = $wpdb->id;
		$ret->staff_id = $wpdb->staff_id;
		$ret->customer_id = $wpdb->customer_id;
		$ret->course_id_list = explode(',', $wpdb->course_id_list);
		$ret->consultation = $wpdb->consultation;
		return $ret;
	}
}

class YoyakuJson
{
	public $customer_id;
	public $start_time;
	public $course_id_list;
	public $schedule_division;
	public $consultation;

	public static function create_from_json(string $json) : self
	{
		$ret = new self();
		$d = json_decode($json);
		$ret->customer_id = $d->customer_id;
		$ret->start_time = $d->start_time;
		$ret->course_id_list =  explode(',', $d->course_id_list);
		$ret->schedule_division = $d->schedule_division;
		$ret->consultation = $d->consultation;
		return $ret;
	}
}

?>