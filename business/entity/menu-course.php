<?php
namespace business\entity;

class MenuCourse
{
	public $menu_id;
	public $course_id;
	public $sequence_no;
	public $first_discount;
	public $name;
	public $time_required;
	public $price;
	
	public static function get_empty_object() : MenuCourse
	{
		return new MenuCourse();
	}
}
?>