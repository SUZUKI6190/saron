<?php
namespace ui\staff;

class FlowYoyakuContext
{
	private static $_instance;
	public $course_id_list;
	public $yoyaku_date;
	public $yoyaku_time;
	public $staff_id;
	public $customer_id;
	private $_param_list = [];

	private function __construct()
	{
		if( !isset($_SESSION) ) {
		  session_start();
		}
		$this->course_id_list = $this->create_param("staff_yoyaku_course_id");
		$this->staff_id = $this->create_param("staff_yoyaku_staff_id");
		$this->yoyaku_date = $this->create_param("staff_yoyaku_date");
		$this->yoyaku_time = $this->create_param("staff_yoyaku_time");
		$this->customer_id = $this->create_param("staff_yoyaku_customer_id");
	}

	public function init()
	{
		$this->save_by_post();
	}

	private function create_param($name)
	{
		$p = new Param($name);
		$this->_param_list[] = $p;
		return $p;
	}

	public function save_by_post()
	{
		foreach($this->_param_list as $p)
		{
			$p->set_session_from_post();
		}
	}

	public function session_destroy()
	{
		foreach($this->_param_list as $p)
		{
			$p->clear();
		}
	}

	public static function get_instance() :self
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

}

class Param
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
		if($this->is_post()){
			$_SESSION[$this->_key] = $_POST[$this->_key];
		}
	}

	public function is_post() : bool
	{
		return isset($_POST[$this->_key]) && $_POST[$this->_key] != "";
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