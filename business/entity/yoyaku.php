<?php
namespace business\entity;

class YoyakuRegistration
{
	public $id;
	public $staff_id;
	public $customer_id;
	public $start_time;
	public $course_id_list;
	public $schedule_division;
	public $consultation;
	public static function CreateObjectFromWpdb($wpdb) : YoyakuRegistration
	{
		$ret = new YoyakuRegistration();
		$ret->start_time = $wpdb->start_time;
		$ret->id = $wpdb->id;
		$ret->staff_id = $wpdb->staff_id;
		$ret->customer_id = $wpdb->customer_id;
		$ret->schedule_division = $wpdb->schedule_division;
		$ret->course_id_list = explode(',', $wpdb->course_id_list);
		$ret->consultation = $wpdb->consultation;
		return $ret;
	}
}

?>