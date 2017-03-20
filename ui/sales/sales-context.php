<?php
namespace ui\sales;

class SalesContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $view_mode;

	public function get_from_month()
	{
		return $_POST['from_month'];
	}
	public function get_to_month()
	{
		return $_POST['to_month'];
	}

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