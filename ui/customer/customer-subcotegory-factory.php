<?php
namespace ui\customer;
require_once("/../frame/manage-frame-context.php");

abstract class CastomerSubBase extends \ui\frame\SubCategory
{
	protected $_context;
	public function __construct(ControlContext $context)
	{
		$this->_context = $context;
	}
}

class SearchSub extends CastomerSubBase
{	
	public function view()
	{
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

function create_customer_sub_category(ControlContext $context)
{
	return [new SearchSub($context)];
}

function create_customer_category(ControlContext $context)
{
	
	if($context->Page == "search"){
		return new SearchSub($context);
	}

	$detailView;
	if($context->RegistMode == 'new'){
		$detailView = new CustomerDetailNew();
	}elseif($context->RegistMode == 'edit'){
		$detailView = new CustomerDetailEdit($context->Id);
	}

	if($detailView->IsSavePost()){
		$detailView->Save();
	}else{
		$detailView->View();
	}
}



?>