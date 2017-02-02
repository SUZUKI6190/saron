<?php
namespace ui\customer;

require_once(dirname(__FILE__).'/../frame/manage-frame.php');

abstract class CustomerSubBase extends \ui\frame\SubCategory
{
	protected $_context;
	public function __construct(ControlContext $context)
	{
		$this->_context = $context;
	}
}

class SearchSub extends CustomerSubBase
{	
	public function view()
	{
		$newUrl = $this->_context->GetCustomerUrl()."/new/";
		$searchUrl = $this->_context->GetCustomerUrl()."/search/";

		if($this->_context->RegistMode == 'detail'){
			$detailView;
			$detailView = new CustomerDetailEdit($this->_context->Id);
			if($detailView->IsSavePost()){
			$detailView->Save();
			}else{
				$detailView->View();
			}
			exit;
		}
		
		view_search($this->_context);

	
	}
	
	public function get_name()
	{
		return "search";
	}
	
	public function get_title_name()
	{
		return "お客様検索";
	}
}


class RegistNewSub extends CustomerSubBase
{	
	public function view()
	{
		$detailView = new CustomerDetailNew();
		if($detailView->IsSavePost()){
			$detailView->Save();
		}else{
			$detailView->View();
		}
	}
	
	public function get_name()
	{
		return "new";
	}
	
	public function get_title_name()
	{
		return "新規登録";
	}
}


class MassRegistrationSub extends CustomerSubBase
{
	public function view()
	{
		
	}
	
	public function get_name()
	{
		return "upload";
	}
	
	public function get_title_name()
	{
		return "ファイルから登録";
	}
}

?>