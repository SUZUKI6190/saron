<?php
namespace ui\sales;

class SalesContext
{
	private static $_instance;
	const FROM_KEY = 'from_month';
	const TO_KEY = 'to_month';
	private function __construct()
	{
	}

	public $view_mode;

	public function enable_view_graph() : bool
	{
		return isset($_POST[SalesContext::FROM_KEY]) && isset($_POST[SalesContext::TO_KEY]);
	}
	
	public function get_from_month()
	{
		return $_POST[SalesContext::FROM_KEY];
	}

	public function get_to_month()
	{
		return $_POST[SalesContext::TO_KEY];
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