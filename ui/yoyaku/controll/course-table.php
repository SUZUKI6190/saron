<?php
namespace ui\yoyaku\controll;
use business\entity\MenuCourse;

class CourseTable
{
	private $_course_list = [];
	public function __construct($couse_list)
	{
		$this->_course_list = $couse_list;
	}
	
	public function view()
	{
		?>
		<table class='course_table'>
		<thead>
		<tr>
			<th class='course_name'>
			選択メニュー
			</th>
			<th class='required_time'>
			所要時間（目安）
			</th>
			<th class='price'>
			料金
			</th>
		</tr>
		</thead>
		<?php
		
		foreach($this->_course_list as $course)
		{
		?>
		<tr class='course_row'>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		</tr>
		<?php
		}
		
		?>
		</table>
		<?php
	}
}

?>