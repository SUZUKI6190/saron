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
		return [
			new SearchSub($this->_context),
			new RegistNewSub($this->_context),
			new MassRegistrationSub($this->_context)
		];
	}

	public function view_main()
	{
		$newUrl = $this->_context->GetCustomerUrl()."/detail/new/";
		$searchUrl = $this->_context->GetCustomerUrl()."/search/";

		if($this->_context->Page == "search"){
			view_search($this->_context);
			exit;
		}

		$detailView;
		if($this->_context->RegistMode == 'new'){
			$detailView = new CustomerDetailNew();
		}elseif($this->_context->RegistMode == 'edit'){
			$detailView = new CustomerDetailEdit($this->_context->Id);
		}

		if($detailView->IsSavePost()){
			$detailView->Save();
		}else{
			$detailView->View();
		}
	}
}

?>