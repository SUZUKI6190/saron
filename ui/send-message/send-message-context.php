<?php
namespace ui\send_message;
use business\entity\SendMessage;
require_once(dirname(__FILE__).'/param.php');

class SendMessageContext
{
	private static $_instance;
	public $page_no = 0;
	public $pre_page_no;
	public $message_id;
	const MaxPageNo = 2;
	private $_msg;

	private $_page_state = 0;
	private $_param_set;
	public $save_btn_state;
	const PageNoKey = "PageNO";
	const PrePageNoKey = "PrePageNo";
	const ProceedPageKey = "proceed";
	const PreviousNoKey = "previous";
	const BackBtnKey = "back_btn";
	const NextBtnKey = "next_btn";

	private function __construct()
	{
		$this->save_btn_state = new ManagePost("SaveBtn");
		$this->_msg = new SendMessage();
	}
	
	public function set_messate(SendMessage $s)
	{
		$this->_message = $s;
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
		if( !isset($_SESSION) ) {
		  session_start();
		}
	
		$this->_param_set = new SendMessageParamSet();

		$this->save_btn_state->get_post_value();

		if(isset($_POST[self::PageNoKey]))
		{
			$this->pre_page_no = $this->page_no;
			$this->page_no = $_POST[self::PageNoKey];
		}

		$this->manage_page();

	}

	public function get_page_no()
	{
		return $this->page_no;
	}

	public function get_pre_page_no()
	{
		return $this->pre_page_no;
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
		$this->pre_page_no = $this->page_no;

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
		$this->_param_set->send_user_name->set_from_param($sm->send_user_name);
		$this->_param_set->message->set_from_param($sm->message_text);
        $this->_param_set->sending_mail->set_from_param($sm->sending_mail);
		$this->_param_set->confirm_mail->set_from_param($sm->confirm_mail);
        $this->_param_set->title->set_from_param($sm->title);
	}

	public function get_param_set():SendMessageParamSet
	{
		return $this->_param_set;
	}

	public function get_sendmessage() : SendMessage
	{
		$this->_msg->id = $this->message_id;

		$this->_msg->send_user_name = $this->_param_set->send_user_name->get_value();
		$this->_msg->sending_mail = $this->_param_set->sending_mail->get_value();
		$this->_msg->confirm_mail = $this->_param_set->confirm_mail->get_value();
		$this->_msg->message_text = $this->_param_set->message->get_value();
		$this->_msg->title = $this->_param_set->title->get_value();

		$this->_msg->sex = $this->_param_set->sex->get_value();
		$this->_msg->enable_dm = $this->_param_set->enable_dm->get_value();
		$this->_msg->occupation = $this->_param_set->occupation->get_value();
		$this->_msg->visit_num_more = $this->_param_set->visit_num->get_more_value();
		$this->_msg->visit_num_less = $this->_param_set->visit_num->get_less_value();
		$this->_msg->reservation_route = $this->_param_set->reservation_route->get_value();
		$this->_msg->staff_id = $this->_param_set->staff->get_value();

		$this->_msg->birth = $this->_param_set->birth->get_value();
		$this->_msg->last_visit = $this->_param_set->last_visit->get_value();
		$this->_msg->next_visit =$this->_param_set->next_visit->get_value();
		return $this->_msg;
	}

	public function update_session()
	{
		foreach($this->_param_set->param_list as $p)
		{
			$p->set_session_from_post();
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
	public $send_user_name, $title, $birth, $last_visit, $next_visit;
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
		$this->send_user_name = new Param("send_user_name");
		$this->title = new Param("title");
		$this->birth = new DaySelectParam("birth_days");
		$this->last_visit = new DaySelectParam("last_visit_days");
		$this->next_visit = new DaySelectParam("next_visit_days");
		$this->sending_mail = new Param("sending_mail");
		$this->confirm_mail = new Param("confirm_mail");
		$this->message = new Param("message");
		$this->occupation = new Param("occupation");
		$this->visit_num = new RangeParam("vist_num");
		$this->reservation_route = new Param("reservation_route");
		$this->sex = new RadioParam("sex");
		$this->staff = new Param("staff");
		$this->enable_dm = new RadioParam("enable_dm");

		$this->param_list = [
			$this->send_user_name,
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

?>