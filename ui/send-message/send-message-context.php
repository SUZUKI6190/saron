<?php
namespace ui\send_message;
use business\entity\SendMessage;

class SendMessageContext
{
	private static $_instance;
	public $page_no = 0;
	private $_param_set;
	const PageNoKey = "PageNO";
	const ProceedPageKey = "proceed";
	const PreviousNoKey = "previous";
	const BackBtnKey = "back_btn";
	const NextBtnKey = "next_btn";

	private function __construct()
	{
	}

	public function init()
	{
		session_start();
	
		$this->_param_set = new SendMessageParamSet();

		if(isset($_POST[self::PageNoKey]))
		{
			$this->page_no = $_POST[self::PageNoKey];
		}

		if(isset($_POST[self::BackBtnKey]))
		{
			$this->page_no -= 1;
            if($this->page_no < 0)
            {
                $this->page_no = 0;
            }			
		}

		if(isset($_POST[self::NextBtnKey]))
        {
			$this->page_no += 1;
            
            if($this->page_no > 2)
            {
                $this->page_no= 2;
            }
        }
	}

	public $message_id;
	
	public static function get_instance() : SendMessageContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SendMessageContext();
		}
		return self::$_instance;
	}

	public function set_session(SendMessage $sm)
	{
		$this->_param_set->message->set_from_param($sm->message_text);
        $this->_param_set->sending_mail->set_from_param($sm->sending_mail);
		$this->_param_set->confirm_mail->set_from_param($sm->confirm_mail);
        $this->_param_set->title->set_from_param($sm->title);

		$this->_param_set->occupation->set_from_param($sm->occupation);
		$this->_param_set->visit_num ->set_from_param($sm->visit_num);
		$this->_param_set->reservation_route->set_from_param($sm->reservation_route);
		$this->_param_set->staff->set_from_param($sm->staff_id);

		$this->_param_set->last_visit->set_from_param($sm->last_visit);
        $this->_param_set->next_visit->set_from_param($sm->next_visit);
        $this->_param_set->birth->set_from_param($sm->birth);
	}

	public function get_param_set():SendMessageParamSet
	{
		return $this->_param_set;
	}

	public function get_sendmessage() : SendMessage
	{
		$msg = new SendMessage();
		$msg->id = $this->message_id;
		$msg->title = $this->_param_set->title->get_value();
		$msg->birth = $this->_param_set->birth->get_value();
		$msg->last_visit = $this->_param_set->last_visit->get_value();
		$msg->next_visit =$this->_param_set->next_visit->get_value();
		$msg->sending_mail = $this->_param_set->sending_mail->get_value();
		$msg->confirm_mail = $this->_param_set->confirm_mail->get_value();
		$msg->message_text = $this->_param_set->message->get_value();
		$msg->occupation = $this->_param_set->occupation->get_value();
		$msg->visit_num = $this->_param_set->visit_num->get_value();
		$msg->reservation_route = $this->_param_set->reservation_route->get_value();

		return $msg;
	}

	public function update_session()
	{
		foreach($this->_param_set->param_list as $p)
		{
			$p->set_session();
		}
	}

	public function set_mail_content()
	{
		$this->_param_set->message->set_session();
        $this->_param_set->sending_mail->set_session();
		$this->_param_set->confirm_mail->set_session();
        $this->_param_set->title->set_session();
	}

	public function set_customer_criteria()
	{
		$this->_param_set->occupation->set_session();
		$this->_param_set->visit_num ->set_session();
		$this->_param_set->reservation_route->set_session();
		$this->_param_set->staff->set_session();
	}

	public function set_send_criteria()
	{
        $this->_param_set->last_visit->set_session();
        $this->_param_set->next_visit->set_session();
        $this->_param_set->birth->set_session();
	}

}

class SendMessageParamSet
{
	public $title, $birth, $last_visit, $next_visit;
	public $sending_mail, $confirm_mail;
	public $message;
	public $occupation;
	public $visit_num;
	public $reservation_route;
	public $staff;
	public $enable_dm;
	public $param_list = [];
	public function __construct()
	{
		$this->title = new Param("title");
		$this->birth = new Param("birth");
		$this->last_visit = new Param("last_visit");
		$this->next_visit = new Param("next_visit");
		$this->sending_mail = new Param("sending_mail");
		$this->confirm_mail = new Param("confirm_mail");
		$this->message = new Param("message");
		$this->occupation = new Param("occupation");
		$this->visit_num = new Param("vist_num");
		$this->reservation_route = new Param("reservation_route");
		$this->staff = new Param("staff");
		$this->enable_dm = new Param("enable_dm");

		$this->param_list = [
			$this->title ,
			$this->birth ,
			$this->last_visit,
			$this->next_visit,
			$this->sending_mail,
			$this->confirm_mail,
			$this->message,
			$this->occupation,
			$this->visit_num,
			$this->reservation_route,
			$this->staff,
			$this->enable_dm 
		];
	}

	public function clear()
	{
		foreach($this->_param_list as $p)
		{
			$p->clear();
		}
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

	public function set_from_param($v)
	{
		$_SESSION[$this->_key] = $v;
	}

	public function set_session()
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
}

?>