<?php
namespace business\entity;

class YoyakuRegistration
{
	public $id;
	public $staff_id;
	public $customer_id;
	public $start_time;
	public $consultation;
	public static function CreateObjectFromWpdb($wpdb) : YoyakuRegistration
	{
		$ret = new YoyakuRegistration();
		$ret->start_time = $wpdb->start_time;
		$ret->id = $wpdb->id;
		$ret->staff_id = $wpdb->staff_id;
		$ret->customer_id = $wpdb->customer_id;
		$ret->consultation = $wpdb->consultation;
		return $ret;
	}
}

?>