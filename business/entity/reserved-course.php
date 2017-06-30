<?php
namespace business\entity;

class ReservedCourse
{
	public $id;
	public $price;
	public $time_required;
	public $name;

	public static function create_from_json($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->price = $wpdb->price;
		$ret->time_required = $wpdb->time_required;
		$ret->name = $wpdb->name;
		return $ret;
	}
}

?>