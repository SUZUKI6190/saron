<?php
namespace ui\frame;
require_once("result.php");
use ui\frame\Result;
class MainCategory
{
	public $name;
	public $text;
	public $default_name;
	public function __construct($name, $text, $default_name)
	{
		$this->name = $name;
		$this->text = $text;
		$this->default_name = $default_name;
	}
}

abstract class SubCategory
{
	abstract public function view();
	abstract public function get_name();
	abstract public function get_title_name();
	public function get_result() : Result
	{
		return new Result();
	}
	public function regist()
	{
	}
	public function pre_view()
	{

	}
}

abstract class GamenBase
{
	public abstract function view();
	public abstract function get_result() : Result;
	public abstract function regist();
	public abstract function next_gamen_id() : string;
	private $_id;
	public function __construct($id)
	{
		$this->_id = $id;
	}
}

abstract class MultiGamenSubCategory extends SubCategory
{
	private $_gamen_list = [];
	public function __construct()
	{
		$this->_gamen_list = $this->get_gamen_list();
	}
	abstract protected function get_gamen_list();
	
	private function get_current_gamen() : Gamen
	{
		$id = $this->get_current_gamen_id();
		return $this->_gamen_list[$id];
	}
	
	abstract protected function get_current_gamen_id() : string;
	public function view()
	{
		
		$this->get_current_gamen()->view();
	}

	public function get_result() : Result
	{
		return $this->get_current_gamen()->get_result();
	}

	public function regist()
	{
		return $this->get_current_gamen()->regist();
	}
}
	
class ManageFrameContext
{
	private static $_current;

	public $main_category_list = [];
	public $template_page_name;

	public $selected_main_category_name;
	public $selected_sub_category_name;
	
	public function get_url()
	{
		return get_bloginfo('url')."/".$this->template_page_name;
	}
	
	public function get_selected_main_category()
	{
		return $this->main_category_list[$this->selected_main_category_name];
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