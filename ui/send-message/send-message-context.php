<?php
namespace ui\send_message;
use business\entity\SendMessage;

class SendMessageContext
{
	private static $_instance;
	public  $page_no = 0;
	public $message_id;
	const MaxPageNo = 2;
	private $_page_state = 0;
	private $_param_set;
	public $save_btn_state;
	const PageNoKey = "PageNO";
	const ProceedPageKey = "proceed";
	const PreviousNoKey = "previous";
	const BackBtnKey = "back_btn";
	const NextBtnKey = "next_btn";

	private function __construct()
	{
		$this->save_btn_state = new ManagePost("SaveBtn");
	}
	
	public static function get_instance() : SendMessageContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SendMessageContext();
		}
		return self::$_instance;
	}

	public function init()
	{
		session_start();
	
		$this->_param_set = new SendMessageParamSet();

		$this->save_btn_state->get_post_value();

		if(isset($_POST[self::PageNoKey]))
		{
			$this->page_no = $_POST[self::PageNoKey];
		}

		$this->manage_page();

	}

	public function get_page_no()
	{
		return $this->page_no;
	}

	public function enable_save_btn()
	{
		 $this->save_btn_state->set_value("1");
	}

	public function is_enable_save_btn():bool
	{
		return $this->save_btn_state->get_value() == 1;
	}

	public function is_max_page() : bool
	{
		return $this->page_no == self::MaxPageNo;
	}

	public function is_min_page() : bool
	{
		return $this->page_no == 0;
	}

	public function get_page_state()
	{
		return $this->_page_state;
	}

	private function manage_page()
	{
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
            
            if($this->page_no > self::MaxPageNo)
            {
                $this->page_no= self::MaxPageNo;
            }
        }
	}

	public function set_session(SendMessage $sm)
	{
		$this->_param_set->message->set_from_param($sm->message_text);
        $this->_param_set->sending_mail->set_from_param($sm->sending_mail);
		$this->_param_set->confirm_mail->set_from_param($sm->confirm_mail);
        $this->_param_set->title->set_from_param($sm->title);

		$this->_param_set->sex->set_from_param($sm->sex);
		$this->_param_set->enable_dm->set_from_param($sm->enable_dm);
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

		$msg->sending_mail = $this->_param_set->sending_mail->get_value();
		$msg->confirm_mail = $this->_param_set->confirm_mail->get_value();
		$msg->message_text = $this->_param_set->message->get_value();
		$msg->title = $this->_param_set->title->get_value();

		$msg->sex = $this->_param_set->sex->get_value();
		$msg->enable_dm = $this->_param_set->enable_dm->get_value();
		$msg->occupation = $this->_param_set->occupation->get_value();
		$msg->visit_num = $this->_param_set->visit_num->get_value();
		$msg->reservation_route = $this->_param_set->reservation_route->get_value();
		$msg->staff_id = $this->_param_set->staff->get_value();

		$msg->birth = $this->_param_set->birth->get_value();
		$msg->last_visit = $this->_param_set->last_visit->get_value();
		$msg->next_visit =$this->_param_set->next_visit->get_value();

		return $msg;
	}

	public function update_session()
	{
		foreach($this->_param_set->param_list as $p)
		{
			$p->set_session();
		}
	}


}

class ManagePost
{
	private $_key;
	private $_value;
	public function __construct(string $key)
	{
		$this->_key = $key;
	}

	public function get_post_value()
	{
		if(isset($_POST[$this->_key])){
			$this->_value = $_POST[$this->_key];
		}else{
			$this->_value = "";
		}
	}

	public function isset()
	{
		return isset($_POST[$this->_key]);
	}

	public function set_value($v)
	{
		$this->_value = $v;
	}

	public function get_value(): string
	{
		return $this->_value;
	}

	public function get_key():string
	{
		return $this->_key;
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
	public $sex;
	public $param_list = [];
	public function __construct()
	{
		$this->title = new Param("title");
		$this->birth = new DaySelectParam("birth_days");
		$this->last_visit = new DaySelectParam("last_visit_days");
		$this->next_visit = new DaySelectParam("next_visit_days");
		$this->sending_mail = new Param("sending_mail");
		$this->confirm_mail = new Param("confirm_mail");
		$this->message = new Param("message");
		$this->occupation = new Param("occupation");
		$this->visit_num = new Param("vist_num");
		$this->reservation_route = new Param("reservation_route");
		$this->sex = new RadioParam("sex");
		$this->staff = new Param("staff");
		$this->enable_dm = new RadioParam("enable_dm");

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
			$this->sex,
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

class RadioParam extends Param
{
	
	public function get_key():string
	{
		return $this->_key."[]";
	}

	public function set_session()
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

	public function set_session()
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
		}
	}
	
}

?>