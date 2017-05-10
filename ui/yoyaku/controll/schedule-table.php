<?php
namespace ui\yoyaku\controll;
use business\entity\WeeklyYoyaku;

class Day
{
	public $month,$day,$year,$week;
}

function time_repeat($f)
{
	$date = new \DateTime('9:00');
	$max_time = new \DateTime('20:00');
	$interval = new \DateInterval('P0DT30M');
	while($date < $max_time)
	{
		$f($date);
		$date->add($interval);
	}
};

class TimeCell
{
    public $enable_yoyaku = false;
	public $day,$time;
}

class TableCol
{
    public $time;
    public $cells = [];

	private function setup($date)
	{
		$new_cell = new TimeCell();
		$time = $date->format('H:i');
		$new_cell->time = $time;
		$this->cells[$time] = $new_cell;
	}

	public function __construct()
	{
		$c = $this->cells;
		time_repeat(function($d){
			$this->setup($d);
		});
	}
}

class ScheduleTable
{
    private $_week_list = [];
	private $_week_list_each_month = [];
    private $_weekly_data;
	private $_col_list = [];
    const week = array("日", "月", "火", "水", "木", "金", "土");
    public function __construct()
	{
        $this->_weekly_data = \business\facade\get_weekly_data();
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
			$this->_col_list[$new_day->month] = new TableCol();
		}
    }
    
	private function view_header()
	{
?>
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
<?php
	}

	public function view()
	{
		?>
		<div class='schedule_select_area'>
		<table class='schedule_select'>
		<thead>
			<?php $this->view_header(); ?>
		</thead>
		<tbody>
			<?php
			time_repeat(function($date){
				$str_time = $date->format('H:i');
			?>
			<tr>
				<td class='td_time'>
				<?php echo $str_time; ?>
				</td>
				<?php
				print_r(count($this->_col_list));
				print_r("<br>");
				foreach($this->_col_list as $col)
				{
					
					$cell = $col->cells[$str_time];
					echo "<td>$cell->enable_yoyaku</td>";
					?>
						<td>
						</td>
					<?php
				}

				?>
			</tr>
			<?php
			}
			);

			?>
		</tbody>
		</table>
		</div>

		<?php
	
	}
}
?>