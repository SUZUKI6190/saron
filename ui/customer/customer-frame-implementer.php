<?php
namespace ui\customer;
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customer-search.php');
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

class CustomerFameImplementer extends \ui\frame\ManageFrameImplementor
{
	private $_context;
	public function __construct(ControlContext $context)
	{
		$this->_context= $context;
	}
	
	public function get_sub_category_list()
	{
		return [new SearchSub($this->_context)];
	}

	public function view_main()
	{
		$newUrl = $this->_context->GetCustomerUrl()."/detail/new/";
		$searchUrl = $this->_context->GetCustomerUrl()."/search/";
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

		if($this->_context->Page == "search"){
			view_search($this->_context);
			exit;
		}

		$detailView;
		if($this->_context->RegistMode == 'new'){
			$detailView = new CustomerDetailNew();
		}elseif($this->_context->RegistMode == 'edit'){
			$detailView = new CustomerDetailEdit($this->_context->Id);
		}

		if($detailView->IsSavePost()){
			$detailView->Save();
		}else{
			$detailView->View();
		}
	}
}

?>