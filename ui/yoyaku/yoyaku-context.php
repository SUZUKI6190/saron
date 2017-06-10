<?php
namespace ui\yoyaku;

class YoyakuContext
{
	private static $_instance;
	public $course_id_list;
	public $staff_id;
	public $yoyaku_date_time;
	public $menu_id;

	private function __construct()
	{
		$this->course_id_list = new YoyakuParam("course_id");
		$this->staff_id = new YoyakuParam("staff_id");
		$this->yoyaku_date_time = new YoyakuParam("yoyaku_date_time");
	}

	public $template_page_name;

	public function get_base_url()
	{
		$template_page_name = get_query_var( 'pagename' );
		return get_bloginfo('url')."/".$this->template_page_name."/yoyaku";
	}
	
	public $yoyaku_id;
	public $sub_category;
	
	public static function get_instance() : YoyakuContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new YoyakuContext();
		}
		return self::$_instance;
	}
}

class YoyakuParam
{
	protected $_key;

	public function get_key():string
	{
		return $this->_key;
	}

	public function __construct(string $key)
	{
		$this->_key = $key;
	}

	public function set_value($v)
	{
		$_SESSION[$this->_key] = $v;
	}

	public function set_session_from_post()
	{
		if(isset($_POST[$this->_key])){
			$_SESSION[$this->_key] = $_POST[$this->_key];
		}
	}

	public function get_value()
	{
		if(isset($_SESSION[$this->_key])){
			return $_SESSION[$this->_key];
		}else{
			return "";
		}
	}

	public function clear()
	{
		unset($_SESSION[$this->_key]);
	}

	public function is_set() : bool
	{
		return isset($_SESSION[$this->_key]);
	}
}

?>