<?php
namespace ui\customer;
require_once("/../frame/manage-frame-contexst.php");
require_once('customer-search.php');

abstract class CastomerSubBase extends SubCotegory
{
	protected $_context;
	public function __construct(ControlContext $context)
	{
		parent::__construct();
		$this->_context = $context;
	}
}

class Search extends CastomerSubBase
{	
	public view()
	{
		view_search($this->_context);
	}
	
	public get_name()
	{
		return "search";
	}
	
	public get_title_name()
	{
		return "お客様検索";
	}
}

function create_customer_category(ControlContext $context)
{
	
	if($context->Page == "search"){
		return new Search($context);
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