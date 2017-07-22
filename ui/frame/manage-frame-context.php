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
	abstract public function init();
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

class ManageFrameContext
{
	private static $_current;
	const LoginKey = 'Login';
	const LogoutBtnName = 'LogoutBtn';
	public $main_category_list = [];

	public $selected_main_category_name;
	public $selected_sub_category_name;
	
	public function get_url()
	{
		return get_bloginfo('url');
	}
	
	public function get_selected_main_category()
	{
		return $this->main_category_list[$this->selected_main_category_name];
	}
	
	public static function get_instance()
	{
		if(is_null(self::$_current))
		{
			self::$_current = new self();
		}
		
		return self::$_current;
	}

	public function set_login_flg()
	{
		$_SESSION[self::LoginKey] = true;
	}

	public function is_login() : bool
	{
		return isset($_SESSION[self::LoginKey]);
	}

	public function is_logout_click() : bool
	{
		return isset($_POST[self::LogoutBtnName]);
	}

	public function set_logout_flg()
	{
		unset($_SESSION[self::LoginKey]);
	}
}

?>