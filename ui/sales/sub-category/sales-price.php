<?php
namespace ui\sales;
require_once('sales-graph-sub-base.php');
require_once('graph-data.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\Sold;
use \business\entity\YoyakuRegistration;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class SumDataCalculator extends DataCalculator
{
	private $_sum = 0;
	public function catch_sold(Sold $y)
	{
		$this->_sum += $y->price;
	}
	public function catch_registration(YoyakuRegistration $y)
	{

	}
	public function get_data()
	{
		return $this->_sum;
	}
}

class PriceMonthlyForm extends MonthlyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumDataCalculator();
	}
}

class PriceDaylyForm extends DaylyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumDataCalculator();
	}
}


class SalesPriceSub extends SalesGraphSubBase
{
	private $_form_id = "menu_form";
	protected function create_monthly_form() : MonthlyForm
	{
		return new PriceMonthlyForm();
	}

	protected  function create_dayly_form() : DaylyForm
	{
		return new PriceDaylyForm();
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