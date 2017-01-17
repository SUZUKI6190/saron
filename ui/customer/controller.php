<?php
namespace ui\customer;
require_once('customerTable.php');
require_once('customerdetail.php');
require_once('customerDetailNew.php');

function ViewTable()
{
	CreateCustomerTable();
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

function CustomerController($detail)
{
	$detailView;
	if($detail == 'new')
	{
		$detailView = new CustomerDetailNew();
	}elseif($detail == 'edit'){
		$detailView = new CustomerDetailNew();
	}
	
	if($detailView->IsSavePost())
	{
		$detailView->Save();
	}else{
		$detailView->View();
	}
}

?>