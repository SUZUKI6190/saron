<?php
namespace ui\yoyaku;

class YoyakuContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $yoyaku_id;
	public $course_id;
	
	public static function get_instance() : YoyakuContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new YoyakuContext();
		}
		return self::$_instance;
	}
}

?>