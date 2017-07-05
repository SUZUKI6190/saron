<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
require_once('customer-search-factory.php');
require_once('customer-search-item.php');
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
class SearchSub extends CustomerSubBase
{	

	private function view_search(ControlContext $c)
	{
		$item = [
			CustomerSearchItemFactory::create_kanjiname(),
			CustomerSearchItemFactory::create_kananame(),
			CustomerSearchItemFactory::create_phonenum(),
			CustomerSearchItemFactory::create_email(),
			CustomerSearchItemFactory::create_old(),
			CustomerSearchItemFactory::create_sex(),

			CustomerSearchItemFactory::create_birthday(),
			CustomerSearchItemFactory::create_occupation(),
			CustomerSearchItemFactory::create_last_visit_item(),
			CustomerSearchItemFactory::create_next_visit_reservation_item(),
			CustomerSearchItemFactory::create_enable_dm()
		];


		$repeater = new SearchitemRepeater($item, $c);
		
		if($c->SearchResult == "result"){
			$repeater->view_search_result();
		}else{
			$repeater->view_search_form();
		}
		
	}

	public function view()
	{
		$newUrl = $this->_context->GetCustomerUrl()."/new/";
		$searchUrl = $this->_context->GetCustomerUrl()."/search/";

		if($this->_context->RegistMode == 'detail'){
			$detailView;
			$detailView = new CustomerDetailEdit($this->_context->Id);
			if($detailView->IsSavePost()){
				$detailView->Save();
			}else{
				$detailView->View();
			}
			exit;
		}
		
		$this->view_search($this->_context);
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

?>