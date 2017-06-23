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

	const BackBtnName = "back_btn";
	const DateTimeBtnName = "yoyaku_date_time";

	protected function init_inner()
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
		"course-table.css"
		];
	}

	public function get_title() : string
	{
		return "日時選択";
	}

	public function pre_render()
	{
		$yc = YoyakuContext::get_instance();
		$d = "?date=".(new \DateTime())->format("Ymdhis");
	
        if($this->is_back())
        {
			$before_url = $yc->get_base_url()."/staff".$d;
            header("Location:$before_url");
        }

        if($this->is_next_move())
        {
			$next_url =  $yc->get_base_url()."/mailform".$d;
			header("Location:$next_url");
        }
	}

	private function is_back(): bool
	{
		return isset($_POST[self::BackBtnName]);
	}

	private function is_next_move(): bool
	{
		return isset($_POST[self::DateTimeBtnName]);
	}


	public function view()
	{
		?>
		<div class='yoyaku_midashi'>
            <span class='page_midasi'>日時を選択してください</span>
        </div>
		<?php
		$yc = YoyakuContext::get_instance();

		$this->course_table->view();
		$this->_shcedule_table->view_week_button();

		$this->_shcedule_table->view();
 		$this->view_yoyaku_frame_hidden();
		?>
		<div class='back_button_area'>
			<input type ='submit' value="< 戻る" name="<?php echo self::BackBtnName; ?>" class="back_button">
		</div>
		
	<?php
	}

}

?>