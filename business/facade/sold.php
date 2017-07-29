<?php
namespace business\entity;

class Sold
{
	public $id;
	public $registration_id;
	public $price;
	public $time_required;
	public $name;
	public $number_of_visit;

	public static function get_empty_object() : MenuCourse
	{
		return new MenuCourse();
	}

	public static function CreateFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->registration_id = $wpdb->registration_id;
		$ret->name = $wpdb->name;
		$ret->price = $wpdb->price;
		$ret->time_required = $wpdb->time_required;
		$ret->name = $wpdb->name;
		$ret->number_of_visit = $wpdb->number_of_visit;
		return $ret;
	}
}
?>