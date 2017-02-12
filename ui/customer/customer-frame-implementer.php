<?php
namespace ui\customer;
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customer-search.php');
require_once('customer-sub-cotegory.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');


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