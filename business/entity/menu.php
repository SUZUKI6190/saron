<?php
namespace business\entity;

class Menu
{
	public $menu_id;
	public $name;
	public $price;
	public $description;
	public $time_required;
	public $enable_reservation;
	public $course_list = [];
	
	public static function get_empty_object() : Menu
	{
		return new Menu();
	}
}

?>