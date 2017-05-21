<?php
namespace ui\send_message;
use business\entity\SendMessage;

class SendMessageContext
{
	private static $_instance;
	private $_param_set;
	private function __construct()
	{
		$this->_param_set = new SendMessageParamSet();
	}

	public $message_id;
	
	public function get_param_set():SendMessageParamSet
	{
		return $this->_param_set;
	}

	public static function get_instance() : SendMessageContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SendMessageContext();
		}
		return self::$_instance;
	}

	public function get_sendmessage() : SendMessage
	{
		$msg->id = $this->message_id;
		$msg->title = $this->_param_set->title->get_value();
		$msg->birth = $this->_param_set->birth->get_day_num();
		$msg->last_visit = $this->_param_set->last_visit->get_day_num();
		$msg->next_visit =$this->_param_set->next_visit->get_day_num();
		$msg->sending_mail = $this->_param_set->sending_mail->get_value();
		$msg->confirm_mail = $this->_param_set->confirm_mail->get_value();
		$msg->message_text = $this->_param_set->message->get_value();
		$msg->occupation = $this->_param_set->occupation->get_value();
		$msg->visit_num = $this->_param_set->vist_num->get_value();
		$msg->reservation_route = $this->_param_set->reservation_route->get_value();
	}

	public function set_mail_content ()
	{
		$this->_param_set->message->set_value();
        $this->_param_set->sending_mail->set_value();
		$this->_param_set->confirm_mail->set_value();
        $this->_param_set->title->set_value();
	}

	public function set_customer_criteria()
	{
		$this->_param_set->occupation->set_value();
		$this->_param_set->vist_num ->set_value();
		$this->_param_set->reservation_route->set_value();
		$this->_param_set->staff->set_value();
	}

	public function set_send_criteria()
	{
		
        $this->_param_set->last_visit->set_value();
        $this->_param_set->next_visit->set_value();
        $this->_param_set->birth->set_value();
	}

}

class SendMessageParamSet
{
	public $title, $birth, $lase_visit, $next_visit;
	public $sending_mail, $confirm_mail;
	public $message;
	public $occupation;
	public $vist_num;
	public $reservation_route;
	public $staff;
	public $enable_dm;

	public function __construct()
	{
		$this->title = new Param("title");
		$this->birth = new Param("birth");
		$this->lase_visit = new Param("last_visit");
		$this->next_visit = new Param("next_visit");
		$this->sending_mail = new Param("sending_mail");
		$this->confirm_mail = new Param("confirm_mail");
		$this->message = new Param("message");
		$this->occupation = new Param("occupation");
		$this->vist_num = new Param("vist_num");
		$this->reservation_route = new Param("reservation_route");
		$this->staff = new Param("staff");
		$this->enable_dm = new Param("enable_dm");
	}
}

class Param
{
	private $_key;

	public function get_key():string
	{
		return $this->_key;
	}

	public function __construct(string $key)
	{
		$this->_key = $key;
	}

	private function set_value()
	{
		$_SESSION[$this->key] = $_POST[$this->key];
	}

	private function get_value() : string
	{
		return $_SESSION[$this->key];
	}
}

?>