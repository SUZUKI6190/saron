<?php
namespace ui\sales;
require_once('sales-graph-sub-base.php');
require_once('graph-data.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\sales;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class SalesPriceSub extends SalesGraphSubBase
{
	private $_form_id = "menu_form";
	const MainColor = "192";
	const OtherColor = "75";
	const Alpha = "0.5";
	const YearsColor = "rgba(192, 75 , 75, 0.4)";
	const LastYearsColor = "rgba(75, 192 , 75, 0.4)";
	const ThreeYearsAgoColor = "rgba(75, 75 , 192, 0.4)";
	
	const ColorTable = [
		self::ThreeYearsAgoColor,
		self::LastYearsColor,
		self::YearsColor
	];

	protected function create_monthly_graph_param() : GraphData
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
			$yr_list = $yealy_list[$year];
			$new_dataset = new DataSet();
			$new_dataset->label = $year;
			$new_dataset->backgroundColor = self::ColorTable[$counter];
			$new_dataset->borderColor = self::ColorTable[$counter];

			foreach($yr_list as $y){
				$reserved_course = \business\facade\get_reserved_course_by_registration_id($y->id);
				foreach($reserved_course as $rc)
				{
					$new_dataset->data[] = $rc->price;
				}
			}
			$ret->dataset_list[] = $new_dataset;
			$counter++;
		}
		return $ret;
	}

	protected function create_dayly_graph_param(\DateTime $from_date, \DateTime $to_date) : GraphData
	{
		$ret = new GraphData();
		return $ret;
	}

	public function get_name()
	{
		return "price";
	}
	
	public function get_title_name()
	{
		return "売上";
	}
	
}
?>