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
	
	private function price_view($value)
	{
		$v = '-';
		if(!empty($value))
		{
			$v = '￥'.$value;
		}
		
		echo $v;
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
			<td class='required_time'>
				<?php echo $c->time_required; ?>分
			</td>
			<td class='price'>
				<?php $this->price_view($c->price); ?>
			</td>
		</tr>
		<?php
			$sum_price = $sum_price + $c->price;
			$sum_time = $sum_time + $c->time_required;
		}
		
		?>
		<tr class='course_row'>
		<td class='sum_midasi'>
		合計
		</td>
		<td class='sum_time'>
			<?php echo $sum_time; ?>分
		</td>
		<td class='sum_price'>
			<?php $this->price_view($sum_price); ?>
		</td>
		</table>
		<?php
	}
}

?>