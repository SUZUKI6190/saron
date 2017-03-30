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
		$sum_price = 0;
		$sum_time = 0;
		foreach($this->_course_list as $c)
		{
		?>
		<tr class='course_row'>
		<td>
			<?php echo $c->name; ?>
		</td>
		<td>
			<?php echo $c->price; ?>
		</td>
		<td>
			<?php echo $c->time_required; ?>
		</td>
		</tr>
		<?php
			$sum_price = $sum_price + $c->price;
			$sum_time = $sum_time + $c->time_required;
		}
		
		?>
		<tr class='course_row'>
		<td>
		合計
		</td>
		<td>
			<?php echo $sum_price; ?>
		</td>
		<td>
			<?php echo $sum_time; ?>
		</td>
		</table>
		<?php
	}
}

?>