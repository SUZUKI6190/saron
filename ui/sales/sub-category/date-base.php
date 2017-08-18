<?php
namespace ui\sales;
use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;
use \business\entity\Reserved;
use \business\entity\YoyakuRegistration;

abstract class DataCalculator
{
	public abstract function catch_reservedcourse(Reserved $y);
	public abstract function catch_registration(YoyakuRegistration $y);
	public abstract function get_data();
}

abstract class DateInputForm
{
	public abstract function view_form();
	protected abstract function create_calculator(): DataCalculator;
	const FromDateName = "from_date";
	const ToDateName = "to_date";
	const YearsColor = "rgba(192, 75 , 75, 0.4)";
	const LastYearsColor = "rgba(75, 192 , 75, 0.4)";
	const ThreeYearsAgoColor = "rgba(75, 75 , 192, 0.4)";
	
	const ColorTable = [
		self::ThreeYearsAgoColor,
		self::LastYearsColor,
		self::YearsColor
	];

	protected function view_input($type, $name, $min, $max, $value)
	{
		$input = sprintf("<input type='%s' name='%s' min='%s' max='%s' value='%s'>", $type, $name, $min, $max, $value);
		echo $input;
	}

	public function get_from_date() 
	{
		if(isset($_POST[self::FromDateName]))
		{
			return $_POST[self::FromDateName];
		}else{
			return "";
		}
	}
	public function get_to_date() 
	{
		if(isset($_POST[self::ToDateName])){
			return $_POST[self::ToDateName];
		}else{
			return "";
		}
	}
}

abstract class MonthlyForm extends DateInputForm
{

	public function view_form()
	{
		/*
		$from_day =  date("Y-m", strtotime("-3 year"));
		$now_day = date('Y-m');
		$this->view_input('month', DateInputForm::FromDateName, $from_day, $now_day, $this->get_from_date());
		?>
		から
		<?php
		$this->view_input('month', DateInputForm::ToDateName, $from_day, $now_day, $this->get_to_date());
		*/
	}
	
	public function create_graph_data() : GraphData
	{
		$ret = new GraphData();
		$m = 1;
		while($m <= 12)
		{
			$ret->labels[] = $m;
			$m++;
		}
		$yealy_list = \business\facade\get_yoyaku_registration_last_3_years();

		$year_list = array_keys($yealy_list);
		$counter = 0;
		foreach($year_list as $year)
		{
			$monthly_list = $yealy_list[$year];
			$month_list = array_keys($monthly_list);

			$new_dataset = new DataSet();
			$new_dataset->label = $year;
			$new_dataset->backgroundColor = DateInputForm::ColorTable[$counter];
			$new_dataset->borderColor = DateInputForm::ColorTable[$counter];

			foreach($month_list as $month)
			{			
				$yr_list = $monthly_list[$month];
				$culc = $this->create_calculator();
				foreach($yr_list as $y)
				{
					$culc->catch_registration($y);
					$reserved_course = \business\facade\get_reserved_by_registration_id($y->id);
					foreach($reserved_course as $rc)
					{
						$culc->catch_reservedcourse($rc);
					}
				}	
				$new_dataset->data[] = $culc->get_data();
			}

			$ret->dataset_list[] = $new_dataset;

			$counter++;
		}
		return $ret;
	}

}

abstract class DaylyForm extends DateInputForm
{
	public function view_form()
	{
		$from_day =  date("Y-m-d", strtotime("-3 year"));
		$now_day = date('Y-m-d');
		?>
		<div class="line">
			<h2>月別</h2>
			<select name='<?php echo DateInputForm::FromDateName; ?>'>
			<?php
				$month_count = 1;
				$selected_mont = 0;
				if($this->is_selected_month())
				{
					$selected_mont = $this->get_selected_month();
				}
				while($month_count <= 12)
				{
					if($month_count==$selected_mont){
						echo sprintf("<option selected value='%s'>%s月</option>", $month_count, $month_count);
					}else{
						echo sprintf("<option value='%s'>%s月</option>", $month_count, $month_count);
					}
					
					$month_count++;
				}
				//$this->view_input('month', DateInputForm::FromDateName, $from_day, $now_day, $this->get_from_date());
			?>
			</select>
		</div>
		<?php
	}
	
	private function is_selected_month() : bool
	{
		return isset($_POST[DateInputForm::FromDateName]);
	}

	private function get_selected_month() : int
	{
		return (int)$_POST[DateInputForm::FromDateName];
	}

	public function create_graph_data() : GraphData
	{
		$selected_data = $this->get_selected_month();
		$yearly_yr_list = \business\facade\get_yoyaku_registration_last_3_years_by_month($selected_data);
		$ret = new GraphData();
		$yearly_list = array_keys($yearly_yr_list);
		$labels_result = [];
		$year_counter = 0;
		foreach($yearly_list as $year)
		{
			$new_dataset = new DataSet();
			$new_dataset->label = $year;
			$new_dataset->backgroundColor = DateInputForm::ColorTable[$year_counter];
			$new_dataset->borderColor = DateInputForm::ColorTable[$year_counter];

			$day_count = 1;
			$labels_day_temp = [];
			foreach($yearly_yr_list[$year] as $dayly_list)
			{
				$culc = $this->create_calculator();
				$dayly = array_keys($dayly_list);
				foreach($dayly as $day)
				{
					$yr = $dayly_list[$day];
					$culc->catch_registration($yr);
					$reserved_course = \business\facade\get_reserved_by_registration_id($yr->id);
					foreach($reserved_course as $rc)
					{			
						$culc->catch_reservedcourse($rc);
					}
				}
				$new_dataset->data[] = $culc->get_data();
				$labels_day_temp[] = $day_count;
				$day_count++;
			}
			$ret->dataset_list[] = $new_dataset;
			$labels_result = count($labels_result) > count($labels_day_temp) ? $labels_result : $labels_day_temp;
			$year_counter++;
		}
		$ret->labels = $labels_result;
		return $ret;
	}
}

?>