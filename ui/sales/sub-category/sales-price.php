<?php
namespace ui\sales;
require_once('sales-sub-base.php');
require_once('graph-data.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\sales;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class SalesPriceSub extends SalesSubBase
{
	private $_form_id = "menu_form";

	protected function create_monthly_graph_param() : GraphData
	{
		$ret = new GraphData();
		$m = 1;
		while($m <= 12)
		{
			$ret->labels[] = $m;
			$m++;
		}
		$yoyaku_list = \business\facade\get_yoyaku_registration_last_3_years();
		foreach($yoyaku_list as $y)
		{
			$reserved_course = \business\facade\get_reserved_course_by_registration_id($y->id);
			$new_dataset = new DataSet();
			foreach($reserved_course as $rc)
			{
				$new_dataset->data[] = $rc->price;
			}
			$ret->dataset_list[] = $new_dataset;
		}
		return $ret;
	}

	protected function create_dayly_graph_param(\DateTime $from_date, \DateTime $to_date) : GraphData
	{
		$ret = new GraphData();
		$yoyaku_list = \business\facade\get_yoyaku_registration_by_date($from_date, $to_date);
		foreach($yoyaku_list as $y)
		{
			$reserved_course = \business\facade\get_reserved_course_by_registration_id($y->id);
			$new_dataset = new DataSet();
			foreach($reserved_course as $rc)
			{
				$new_dataset->data[] = $rc->price;
			}
			$ret->dataset_list[] = $new_dataset;
		}
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