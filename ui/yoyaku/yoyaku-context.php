<?php
namespace ui\yoyaku;

class YoyakuContext
{
	private static $_instance;
	public $course_id_list;
	public $staff_id;
	public $yoyaku_date_time;
	public $menu_id;
	public $mail_contents;

	private function __construct()
	{
		session_id ("yoyakumenu");
		session_start();
		$this->course_id_list = new YoyakuParam("course_id");
		$this->staff_id = new YoyakuParam("staff_id");
		$this->yoyaku_date_time = new YoyakuParam("yoyaku_date_time");
		$this->mail_contents = new MailContents();
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

	public function session_destroy()
	{
		//$_SESSION = array();
		session_destroy();
	}
}

class MailContents
{
	public $name_kanji;
	public $name_kana;
	public $email;
	public $tell;
	public $visit;
	public $consultation;

	public function __construct()
	{
		$this->name_kanji = new YoyakuParam("name_kanji");
		$this->name_kana = new YoyakuParam("name_kana");
		$this->email = new YoyakuParam("email");
		$this->tell= new YoyakuParam("tell");
		$this->visit = new YoyakuParam("visit");
		$this->consultation = new YoyakuParam("consultation");
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