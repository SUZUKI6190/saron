<?php
namespace ui\staff;

class StaffContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $staff_id;
	
	public static function get_instance() : StaffContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new StaffContext();
		}
		return self::$_instance;
	}
}

?>