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

class SumNumDataCalculator extends DataCalculator
{
	private $_sum = 0;
	public function culc_data(ReservedCourse $y)
	{
		$this->_sum += 1;
	}
	public function get_data()
	{
		return $this->_sum;
	}
}

class NumMonthlyForm extends MonthlyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumNumDataCalculator();
	}

}

class NumDaylyForm extends DaylyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumNumDataCalculator();
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