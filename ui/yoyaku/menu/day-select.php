<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;
require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;

class Day
{
	public $month,$day,$year,$week;
}


class DaySelect extends YoyakuMenu
{
	private $course_table;

	private $_week_list = [];
	private $_week_list_each_month = [];
	const week = array("日", "月", "火", "水", "木", "金", "土");
	public function __construct()
	{
		$course_id_list = explode(',', $_POST["course_id"]);
		$course_list = \business\facade\get_menu_course_by_idlist($course_id_list);
		$this->course_table = new CourseTable($course_list);
		for($i = 0 ; $i < 7 ; $i++)
		{
			$new_day = new Day();
			$new_day->year = date("Y",strtotime("+$i day"));
			$new_day->month = date("M",strtotime("+$i day"));
			$new_day->day = (int)date("d",strtotime("+$i day"));
			$new_day->week = self::week[date("w",strtotime("+$i day"))];
			$year_month = date("Y年m月",strtotime("+$i day"));
			$this->_week_list[] = $new_day;
			$this->_week_list_each_month[$year_month][] = $new_day;
		}
	}
	
	public function get_title() : string
	{
		return "日時選択";
	}
	
	public function view()
	{
		$this->course_table->view();
		$yc = YoyakuContext::get_instance();


		$this->view_calendar();
		
	}

	public function view_calendar()
	{
		?>
		<div class='schedule_select_area'>
		<table class='schedule_select'>
		<thead>
		<tr>
			<th rowspan="3">
			日時
			</th>
			<?php
			foreach(array_keys($this->_week_list_each_month) as $w)
			{
				$count = count($this->_week_list_each_month[$w]);
				?>
				<th colspan='<?php echo $count; ?>'>
				<?php echo $w; ?>
				</th>
				<?php
			}
			?>
		</tr>
		<tr>
			<?php
			foreach($this->_week_list as $w)
			{
				echo "<th>$w->day</th>";
			}
			?>
		</tr>
		<tr>
			<?php
			foreach($this->_week_list as $w)
			{
			?>
			<th>
			(<?php echo $w->week; ?>)
			</th>
			<?php	
			}
			?>
		</tr>
		<tr>
			<th colspan='8'>
			</th>
		</tr>
		</thead>
		</table>
		</div>

		<?php
	
	}
}

?>