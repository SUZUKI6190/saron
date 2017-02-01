<?php
namespace ui/customer;
require_once("");
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customer-search.php');


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

class CustomerFameImplementer extends ManageFrameImplementor
{
	private _context;
	public function __construct(ControlContext $context)
	{
		$this->_context= $context;
	}
	
	public function get_sub_category_list()
	{
		return [new SearchSub($context)];
	}
	
	public function get_main_category_list()
	{
	}
	
	public function view_main()
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
}

?>