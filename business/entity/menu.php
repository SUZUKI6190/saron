<?php
namespace business\entity;

class Menu
{
	public $menu_id;
	public $name;
	public $description;
	public $enable_reservation = 0;
	public $course_list = [];
	
	public static function get_empty_object() : Menu
	{
		return new Menu();
	}
}

?>