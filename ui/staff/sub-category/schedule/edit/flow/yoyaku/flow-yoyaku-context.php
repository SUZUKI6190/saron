<?php
namespace ui\staff;
use business\entity\StaffSchedule;

class FlowYoyakuContext
{
	private static $_instance;
	public $course_id_list;
	public $yoyaku_date;
	public $yoyaku_time;
	public $staff_id;
	public $customer_id;
	public $schedule_id;
	public $consultation;
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
		$this->schedule_id = $this->create_param(StaffContext::edit_btn_name);
		$this->consultation = $this->create_param("staff_yoyaku_consultation");
	}

	public function init()
	{
		$this->save_by_post();
	}

	public function set_edit_data()
	{
		if(!isset($_POST[StaffContext::edit_btn_name])){
			return;
		}
		$schedule_id = $_POST[StaffContext::edit_btn_name];
		$data = \business\facade\StaffScheduleFacade::get_by_schedule_id($schedule_id);
		$this->course_id_list->set_value($data->course_id_list);
		$this->yoyaku_date->set_value($data->start_time->format('Y-m-d'));
		$this->yoyaku_time->set_value($data->start_time->format('H:i'));
		$this->customer_id->set_value($data->customer_id);
		$this->schedule_id->set_value($data->schedule_id);
		$this->consultation->set_value($data->consultation);
	}

	public function create_input_scheule_data() : StaffSchedule
	{
		$new_data = new StaffSchedule();
		$new_data->course_id_list = $this->course_id_list->get_value();
		$new_data->start_time = $this->yoyaku_date->get_value().' '.$this->yoyaku_time->get_value();
		$new_data->customer_id = $this->customer_id->get_value();
		$new_data->schedule_id = $this->schedule_id->get_value();
		$new_data->consultation = $this->consultation->get_value();
		return $new_data;
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