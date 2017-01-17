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
	echo $detail;
	if($detail == 'new')
	{
		$detailView = new CustomerDetailNew();
	}elseif($detail == 'edit')
	{
		$detailView = new CustomerDetailNew();
	}
	
	$detailView->View();
	
}

?>