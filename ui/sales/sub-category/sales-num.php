<?php
namespace ui\sales;
require_once('sales-graph-sub-base.php');
require_once('graph-data.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\ReservedCourse;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class NumMonthlyForm extends MonthlyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return 1;
	}
}

class NumDaylyForm extends DaylyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return 1;
	}
}


class SalesNumSub extends SalesGraphSubBase
{
	
	protected function create_monthly_form() : MonthlyForm
	{
		return new NumMonthlyForm();
	}

	protected  function create_dayly_form() : DaylyForm
	{
		return new NumDaylyForm();
	}

	public function get_name()
	{
		return "numberof";
	}
	
	public function get_title_name()
	{
		return "来店客数";
	}
	
}
?>