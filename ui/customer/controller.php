<?php
namespace ui\customer;
require_once('customerTable.php');
require_once('customerdetail.php');
require_once('customerDetailNew.php');

class ControlContext
{
	public $Page;
	public $RegistMode;
	public $Id;
}

function ViewTable()
{
	CreateCustomerTable();
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

function CustomerController(ControlContext $context)
{
	$detailView;
	if($context->RegistMode == 'new')
	{
		$detailView = new CustomerDetailNew();
	}elseif($context->RegistMode == 'edit'){
		$detailView = new CustomerDetailNew();
	}
	
	if($detailView->IsSavePost())
	{
		echo "save";
		$detailView->Save();
	}else{
		$detailView->View();
	}
}

?>