<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
require_once(dirname(__FILE__).'/../controll/schedule-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;
require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;
use ui\yoyaku\controll\ScheduleTable;

class DaySelect extends YoyakuMenu
{
	private $course_table;
	private $_shcedule_table;
	private $_week_list = [];
	private $_week_list_each_month = [];
	public function __construct()
	{
		$course_id_list = explode(',', $_POST["course_id"]);
		$course_list = \business\facade\get_menu_course_by_idlist($course_id_list);
		$this->course_table = new CourseTable($course_list);
		$this->_shcedule_table = new ScheduleTable();
	}
	
	public function get_title() : string
	{
		return "日時選択";
	}
	
	public function view()
	{
		$this->course_table->view();
		$yc = YoyakuContext::get_instance();
		$this->_shcedule_table->view();
		
	}

}

?>