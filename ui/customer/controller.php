<?php
namespace ui\customer;
require_once('customerTable.php');
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customerSearch.php');

class ControlContext
{
	public $Page;
	public $RegistMode;
	public $Id;
	public $TemplatePageName;
	
	public function GetCustomerUrl()
	{
		return get_bloginfo('url')."/".$this->TemplatePageName."/customer";
	}
}

function ViewTable(ControlContext $c)
{
	$newUrl = $c->GetCustomerUrl()."/detail/new/";
	?>
	<form method = 'post' action='<?php echo $newUrl; ?>'>
		<input type='submit' value="新規登録" /></br>
	<form>
	<?php

	CreateCustomerTable($c);
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

function view_search_page()
{
	view_search();
}

function CustomerController(ControlContext $context)
{
	if($context->Page == "view"){
		ViewTable($context);
		exit;
	}elseif($context->Page == "search"){
		
		view_search_page();
		exit;
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