<?php
namespace ui\customer;
require_once(dirname(__FILE__).'/../../business/facade/customer.php');
require_once(dirname(__FILE__).'/../../business/entity/customer.php');
require_once(dirname(__FILE__).'/sub-category/customer-sub-base.php');
require_once(dirname(__FILE__).'/customer-context.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/customer.php');

class CustomerFameImplementor extends \ui\frame\ManageFrameImplementor
{
	public function __construct()
	{
	}
	
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new SearchSub());
		$set_array(new RegistNewSub());
		$set_array(new MassRegistrationSub());
		$set_array(new DeleteSub());
		
		return $ret;
	}

	public function view_main()
	{
		
	}
}

?>