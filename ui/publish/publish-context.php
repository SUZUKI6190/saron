<?php
namespace ui\publish;

class PublishContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $menu_id;
	public $edit_mode;

	public static function get_instance() : PublishContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new PublishContext();
		}
		return self::$_instance;
	}
}

?>