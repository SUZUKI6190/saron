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

class PerCustomerMonthlyForm extends MonthlyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return 1;
	}
}

class PerCustomerDaylyForm extends DaylyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return 1;
	}
}


class SalesPerCustomerSub extends SalesGraphSubBase
{
	
	protected function create_monthly_form() : MonthlyForm
	{
		return new PerCustomerMonthlyForm();
	}

	protected  function create_dayly_form() : DaylyForm
	{
		return new PerCustomerDaylyForm();
	}

	public function get_name()
	{
		return "percustomer";
	}
	
	public function get_title_name()
	{
		return "客単価";
	}
	
}
?>