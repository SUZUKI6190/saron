<?php
namespace ui\customer;
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customer-search.php');

class ControlContext
{
	public $Page;
	public $RegistMode;
	public $Id;
	public $TemplatePageName;
	public $SearchResult;
	public function GetCustomerUrl()
	{
		return get_bloginfo('url')."/".$this->TemplatePageName."/customer";
	}
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

function CustomerController(ControlContext $context)
{

	$newUrl = $context->GetCustomerUrl()."/detail/new/";
	$searchUrl = $context->GetCustomerUrl()."/search/";
	?>
	<div class ="customer_header" >
		<a href = '<?php echo $searchUrl; ?>'>
			<div class="sub_header_button">
				お客様検索
			</div>
		</a>
		<a href = '<?php echo $newUrl; ?>' >
			<div class="sub_header_button">
				新規登録
			</div>
		</a>
	</div>
	<?php

	if($context->Page == "search"){
		view_search($context);
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