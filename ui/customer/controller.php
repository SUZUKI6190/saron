<?php
namespace ui\customer;
require_once('customerTable.php');
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');

class ControlContext
{
	public $Page;
	public $RegistMode;
	public $Id;
}

function ViewTable()
{
	$newUrl = get_bloginfo('url')."/manage/customer/detail/new/"
	?>
	<form method = 'post' action='<?php echo $newUrl; ?>'>
		<input type='submit' value="新規登録" /></br>
	<form>
	<?php

	CreateCustomerTable();
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

function CustomerController(ControlContext $context)
{
	if($context->Page == "view")
	{
		ViewTable();
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