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
	private $_course_id_list;
	public function __construct()
	{
		$this->_course_id_list = $this->get_course_id_list();
		$course_list = \business\facade\get_menu_course_by_idlist($this->_course_id_list);
		$this->course_table = new CourseTable($course_list);
		$this->_shcedule_table = new ScheduleTable();
	}

	protected function get_css_list() : array
	{
		return [
		"day-select.css",
		"course-table.css"];
	}
	
	public function get_title() : string
	{
		return "日時選択";
	}
	

	public function view()
	{
		$yc = YoyakuContext::get_instance();
		$d = "?date=".(new \DateTime())->format("Ymdhis");
		$before_url = $yc->get_base_url()."/"."staff".$d;
		$this->view_yoyaku_frame_hidden();
		?>
		<form method='post' action=''>
		<input type="hidden" name="course_id" value='<?php echo $course_id; ?>'>
		<?php
		$this->course_table->view();
		$yc = YoyakuContext::get_instance();
		$this->_shcedule_table->view();
		?>
		</form>

		<form method='post' action='<?php echo $before_url; ?>'>
			<?php $this->view_yoyaku_frame_hidden(); ?>
			<div class='back_button_area'>
				<input type ='submit' value="戻る" class="back_button">
			</div>
		</form>
	<?php
	}

}

?>