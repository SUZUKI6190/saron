<?php
namespace business\entity;

class MenuCourse
{
	public $menu_id;
	public $id;
	public $sequence_no;
	public $first_discount;
	public $name;
	public $time_required;
	public $price;
	
	public static function get_empty_object() : MenuCourse
	{
		return new MenuCourse();
	}

	public static function CreateFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->menu_id = $wpdb->menu_id;
		$ret->name = $wpdb->name;
		$ret->price = $wpdb->price;
		$ret->time_required = $wpdb->time_required;
		$ret->sequence_no = $wpdb->sequence_no;
		$ret->first_discount = $wpdb->first_discount;
		return $ret;
	}
}
?>