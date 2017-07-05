<?php
namespace ui\customer;
require_once(dirname(__FILE__).'/../../business/facade/customer.php');
require_once(dirname(__FILE__).'/../../business/entity/customer.php');
require_once(dirname(__FILE__).'/sub-category/customer-sub-cotegory.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/customer.php');

class CustomerFameImplementor extends \ui\frame\ManageFrameImplementor
{
	private $_context;
	public function __construct(ControlContext $context)
	{
		$this->_context= $context;
	}
	
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new SearchSub($this->_context));
		$set_array(new RegistNewSub($this->_context));
		$set_array(new MassRegistrationSub($this->_context));
		$set_array(new DeleteSub($this->_context));
		
		return $ret;
	}

	public function view_main()
	{
		
	}
}

?>