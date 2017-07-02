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

class PriceMonthlyForm extends MonthlyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return $y->price;
	}
}

class PriceDaylyForm extends DaylyForm
{
	protected function get_graph_data(ReservedCourse $y): int
	{
		return $y->price;
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