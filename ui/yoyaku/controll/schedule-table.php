<?php
namespace ui\yoyaku\controll;
use business\entity\WeeklyYoyaku;

class Day
{
	public $month,$day,$year,$week;
}

class TimeCell
{
    public $enable_yoyaku,$day,$time;
}

class TimeCol
{
    public $time;
    public $cells = [];
}

class ScheduleTable
{
    private $_week_list = [];
	private $_week_list_each_month = [];
    private $_weekly_data;
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
			$date = new \DateTime('9:00');
			$max_time = new \DateTime('20:00');
			$interval = new \DateInterval('P0DT30M');
			while($date < $max_time)
			{
			?>
			<tr>
				<td class='td_time'>
				<?php echo $date->format('H:i'); ?>
				</td>
			</tr>
			<?php
				$date->add($interval);
			}
			?>
		</tbody>
		</table>
		</div>

		<?php
	
	}
}
?>