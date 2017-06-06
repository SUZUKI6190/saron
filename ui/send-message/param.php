<?php
namespace ui\send_message;
use business\entity\SendMessage;

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

	public function set_from_param($v)
	{
		$_SESSION[$this->_key] = $v;
	}

	public function set_session_from_post()
	{
		if(isset($_POST[$this->_key])){
			$_SESSION[$this->_key] = $_POST[$this->_key];
		}
	}

	public function get_value() : string
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


class RangeParam  extends Param
{
	protected $_key_less, $_key_more;

	public function __construct(string $key)
	{
		parent::__construct($key);
		$this->_key_less = $key."_less";
		$this->_key_more = $key."_more";
	}

	public function get_less_key():string
	{
		return $this->_key_less;
	}

	public function get_more_key():string
	{
		return $this->_key_more;
	}

	public function set_from_range_param($v_less, $v_more)
	{
		$_SESSION[$this->_key_less] = $v_less;
		$_SESSION[$this->_key_more] = $v_more;
	}

	public function set_session_from_post()
	{
		if(isset($_POST[$this->_key_less])){
			$_SESSION[$this->_key_less] = $_POST[$this->_key_less];
		}
		if(isset($_POST[$this->_key_more])){
			$_SESSION[$this->_key_more] = $_POST[$this->_key_more];
		}
	}

	public function get_less_value() : string
	{
		if(isset($_SESSION[$this->_key_less])){
			return $_SESSION[$this->_key_less];
		}else{
			return "";
		}
	}

	public function get_more_value() : string
	{
		if(isset($_SESSION[$this->_key_more])){
			return $_SESSION[$this->_key_more];
		}else{
			return "";
		}
	}

	public function clear()
	{
		unset($_SESSION[$this->_key_less]);
		unset($_SESSION[$this->_key_more]);
	}

	public function is_set() : bool
	{
		return isset($_SESSION[$this->_key_less]) && isset($_SESSION[$this->_key_more]);
	}
}


class RadioParam extends Param
{
	
	public function get_key():string
	{
		return $this->_key."[]";
	}

	public function set_session_from_post()
	{
		if(isset($_POST[$this->_key])){
			$_SESSION[$this->_key] = $_POST[$this->_key][0];
		}
	}
}

class DaySelectParam extends Param
{
	public function get_radio_key(): string
	{
		return $this->_key."_select[]";
	}

	public function get_value() : string
	{
		if(isset($_SESSION[$this->_key])){
			return $_SESSION[$this->_key];
		}else{
			return "";
		}
	}


	public function set_session_from_post()
	{
		$rk =  $this->_key."_select";
		if(!isset($_POST[$rk]))
		{
			return;
		}
		$selected_value = $_POST[$rk][0];
		if(isset($_POST[$this->_key])){
			switch($selected_value)
			{
				case "日前":
					$_SESSION[$this->_key] = -(int)$_POST[$this->_key];
					break;
				case "日後":
					$_SESSION[$this->_key] = (int)$_POST[$this->_key];
					break;
				default:
					$_SESSION[$this->_key] = 0;
					break;
			}
		}else{
			$_SESSION[$this->_key] = null;
		}
	}
	
}

?>