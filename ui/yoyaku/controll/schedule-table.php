<?php
namespace ui\yoyaku\controll;
use business\entity\WeeklyYoyaku;
use ui\util\InputControll;
use ui\util\SubmitButton;

require_once(dirname(__FILE__).'/yoyaku-button.php');
use ui\yoyaku\controll\YoyakuToggle;

class Day
{
	public $month,$day,$year,$week;
}

function time_repeat($f)
{
	$date = new \DateTime('9:00');
	$max_time = new \DateTime('21:00');
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
	public $button;

	public function __construct(\DateTime $d)
	{
		$this->button = new YoyakuToggle($d);
	}
	public function view()
	{
		$this->button->view();
	}
}

class TableCol
{
    public $time;
    public $cells = [];

	private function setup($date)
	{
		$new_cell = new TimeCell($date);
		$time = $date->format('H:i:s');
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
	private $_start_day_add = 0;
	private $_add_day_hidden;
	private $_next_week_button, $_before_week_button;

    const week = array("日", "月", "火", "水", "木", "金", "土");
    public function __construct()
	{
		$this->_add_day_hidden = new InputControll("hidden", "add_day_value");
		$this->_before_week_button = new SubmitButton('before_week', "< 前週", "", "week_change");
		$this->_next_week_button = new SubmitButton('next_week', "翌週 >", "", "week_change");

        for($i = 0 ; $i < 7 ; $i++)
		{
			$new_day = new Day();
			$date = $this->get_start_day($i);
			$new_day->year = date("Y", $date);
			$new_day->month = date("M", $date);
			$new_day->day = (int)date("d", $date);
			$new_day->week = self::week[date("w", $date)];
			$year_month = date("Y年m月", $date);
			$this->_week_list[] = $new_day;
			$this->_week_list_each_month[$year_month][] = $new_day;
			$this->_col_list[$new_day->week] = new TableCol();
		}

		//曜日ごとの設定の反映
		$this->_weekly_data = \business\facade\get_weekly_data();
		foreach($this->_weekly_data as $wd)
		{
			$week = $wd->get_week_char();

			if($week != "祝日"){
				$col = $this->_col_list[$week];
				foreach($col->cells as $key => $value)
				{
					$key_time = strtotime($key);
					if(strtotime($wd->from_time) <= $key_time)
					{
						if(strtotime($wd->to_time) >= $key_time)
						{
							$col->cells[$key]->button->enable_yoyaku = true;
						}
					}
				}
				
			}else{

			}
			
		}
    }
    
	private function get_start_day(int $add_day) : int
	{
		$next_add_value = 0;
		if($this->_add_day_hidden->exist_value()){
			$hidden_add_value = (int)($this->_add_day_hidden->get_value());
		}else{
			$hidden_add_value = 0;
		}
		if($this->_before_week_button->is_submit())
		{
			$v = $hidden_add_value - 7;
			$next_add_value = ($v < 0) ? 0 : $v;
		}
		if($this->_next_week_button->is_submit())
		{
			$next_add_value = $hidden_add_value + 7;
		}
		$this->_start_day_add = $next_add_value;
		$add = $this->_start_day_add + $add_day;
		return strtotime("+$add day");
	}

	private function view_header()
	{
?>
		<tr>
			<th rowspan="3">
			日時
			</th>
			<?php
			foreach(array_keys($this->_week_list_each_month) as $key)
			{
				$count = count($this->_week_list_each_month[$key]);
				?>
				<th colspan='<?php echo $count; ?>'>
				<?php echo $key; ?>
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

	public function view_week_button()
	{
		?>
		<div class='week_button_area'>
			<?php
			$this->_before_week_button->view();
			$this->_next_week_button->view();
			?>
		</div>
		<?php
		$this->_add_day_hidden->set_value($this->_start_day_add);
		$this->_add_day_hidden->view();
	}

	public function view()
	{
		$this->_add_day_hidden->set_value($this->_start_day_add);
		$this->_add_day_hidden->view();
		?>
		<div class='schedule_select_area'>
		<table class='schedule_select'>
		<thead>
			<?php $this->view_header(); ?>
		</thead>
		<tbody>
			<?php
			time_repeat(function($date){
				$str_time = $date->format('H:i:s');
				?>
				<tr>
					<td class='td_time'>
					<?php echo $date->format('H:i'); ?>
					</td>
					<?php
					foreach($this->_col_list as $key => $col)
					{
						$cell = $col->cells[$str_time];
						echo "<td>";
						$cell->view();
						echo "</td>";				
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