<?php
namespace ui\frame;

class MainCategory
{
	public $name;
	public $text;
	public function __construct($name, $text)
	{
		$this->name = $name;
		$this->text = $text;
	}
}

abstract class SubCategory
{
	abstract public function view();
	abstract public function get_name();
	abstract public function get_title_name();
}
	
class ManageFrameContext
{
	private static $_current;
	
	public static $current_main_category;
	public static $current_sub_category;

	public $main_category_list = [];
	public $template_page_name;

	public function get_url()
	{
		return get_bloginfo('url')."/".$this->template_page_name;
	}
	
	public static function get_instance()
	{
		if(is_null(self::$_current))
		{
			self::$_current = new ManageFrameContext();
		}
		
		return self::$_current;
	}
}

?>