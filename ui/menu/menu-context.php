<?php
namespace ui\menu;

class MenuContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $menu_id;
	public $course_id;
	
	public static function get_instance() : MenuContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new MenuContext();
		}
		return self::$_instance;
	}
}

?>