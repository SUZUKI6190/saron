<?php
namespace ui\schedule;

class ScheduleContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public static function get_instance() : ScheduleContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new ScheduleContext();
		}
		return self::$_instance;
	}
}

?>