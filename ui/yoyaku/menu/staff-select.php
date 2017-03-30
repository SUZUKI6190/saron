<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\YoyakuContext;
use business\entity\Staff;

require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;

class StaffSelect extends YoyakuMenu
{
	private $_staff_list = [];
	private $_course_id_list = [];
	private $_form_id = 'rest_form';

	private $course_table;
	
	public function __construct()
	{
		$yc = YoyakuContext::get_instance();
		$this->_staff_list = \business\facade\get_staff_all();
		$this->_course_id_list = $_POST['course_id'];

		$course_list = \business\facade\get_menu_course_by_idlist($this->_course_id_list);
		$this->course_table = new CourseTable($course_list);
	}

	public function get_title() : string
	{
		return "セラピスト選択";
	}

	private function view_staff_info(Staff $s)
	{
		?>
		<div class='staff_info'>
			<div class='staff_image_wrap'>
				<img class='staff_image' src='<?php echo $s->image; ?>' />
			</div>
			<div class='staff_name'>
				<span><?php echo $s->name_last.' '.$s->name_first ?></span>
			</div>
		</div>
		<?php
		$s->name_first;
	}

	public function view()
	{
		?>
		<div class = 'yoyaku_midashi'>
			<span>セラピストを選択してください</span>
		</div>
		<div class='course_table_area'>
		<?php
		$this->course_table->view();
		?>
		</div>
		<div class='staff_select_area'>
		<?php
		foreach($this->_staff_list as $s)
		{
			$this->view_staff_info($s);
		}
		?>
		</div>
		<?php
	}
}

?>