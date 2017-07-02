<?php
namespace ui\sales;
use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;
use business\entity\ReservedCourse;

abstract class DateInputForm
{
	public abstract function view_form();
	protected abstract function get_graph_data(ReservedCourse $y) : int;
	public abstract function create_graph_data() : GraphData;
	const FromDateName = "from_date";
	const ToDateName = "to_date";

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
	const YearsColor = "rgba(192, 75 , 75, 0.4)";
	const LastYearsColor = "rgba(75, 192 , 75, 0.4)";
	const ThreeYearsAgoColor = "rgba(75, 75 , 192, 0.4)";
	
	const ColorTable = [
		self::ThreeYearsAgoColor,
		self::LastYearsColor,
		self::YearsColor
	];

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
			$new_dataset->backgroundColor = self::ColorTable[$counter];
			$new_dataset->borderColor = self::ColorTable[$counter];

			foreach($month_list as $month)
			{			
				$yr_list = $monthly_list[$month];
				$sum_data = 0;
				foreach($yr_list as $y)
				{
					$reserved_course = \business\facade\get_reserved_course_by_registration_id($y->id);
					foreach($reserved_course as $rc)
					{
						$sum_data += $this->get_graph_data($rc);
					}
				}	
				$new_dataset->data[] = $sum_data;
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
			<?php
				$this->view_input('date', DateInputForm::FromDateName, $from_day, $now_day, $this->get_from_date());
				?>
				から	
				<?php
				$this->view_input('date', DateInputForm::ToDateName, $from_day, $now_day, $this->get_to_date());
				?>			
		</div>
		<?php
	}
	
	public function create_graph_data() : GraphData
	{
		$ret = new GraphData();
		$new_dataset = new DataSet();
		$m = 1;
		while($m <= 31)
		{
			$ret->labels[] = $m;
			$m++;
		}
		return $ret;
	}
}

?>