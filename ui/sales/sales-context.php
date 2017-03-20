<?php
namespace ui\sales;

class SalesContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $view_mode;

	public static function get_instance() : SalesContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SalesContext();
		}
		return self::$_instance;
	}
}

?>