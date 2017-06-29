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

	protected function create_graph_param(Sales $sales)
	{
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