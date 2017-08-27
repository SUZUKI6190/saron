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

class PerCustomerDataCalculator extends DataCalculator
{
	private $_customer_num = 0;
	private $_price_num = 0;
	public function catch_sold(Sold $y)
	{
		$this->_price_num += $y->price;
	}
	public function catch_registration(YoyakuRegistration $y)
	{
		$this->_customer_num += 1;
	}
	public function get_data()
	{
		if($this->_customer_num == 0)
		{
			return 0;
		}
		if($this->_price_num == 0)
		{
			return 0;
		}
		return $this->_price_num / $this->_customer_num;
	}
}


class PerCustomerMonthlyForm extends MonthlyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new PerCustomerDataCalculator();
	}
}

class PerCustomerDaylyForm extends DaylyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new PerCustomerDataCalculator();
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