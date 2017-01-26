<?php
namespace ui\frame;

class MainCategory
{
	private $_sub_category_list;
	public $name;
}

abstract class SubCategory
{
	abstract public function view();
	abstract public function get_name();
	abstract public function get_title_name();
}

class CurrentState
{
	public static $main_category;
	public static $sub_category;
}
	
class ManagFrameContext
{
	private static $_current;

	public $main_category_list;

	public static function get_instance()
	{
		if(is_null(PageContext::$_current))
		{
			PageContext::$_current = new ManagFrameContext();
		}
		
		return PageContext::$_current;
	}
}

?>