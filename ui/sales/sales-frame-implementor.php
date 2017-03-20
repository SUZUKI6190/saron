<?php
namespace ui\sales;
require_once('sales-context.php');
require_once('sub-category/sales-price.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/sales.php');
require_once(dirname(__FILE__).'/../../business/entity/sales.php');
use \ui\frame\ManageFrameImplementor;

class SalesFrameImplementor extends ManageFrameImplementor
{
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new SalesPriceSub());
		
		
		return $ret;
	}

	public function view_main()
	{
		
	}
}
	


?>