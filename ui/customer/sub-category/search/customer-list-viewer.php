<?php
namespace ui\customer;

class CustomerListViwer implements SearchViewer
{
	public function init()
	{

	}

	public function view()
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


		$repeater = new SearchitemRepeater($item);
		$c = CustomerContext::get_instance();
		if($repeater->is_search()){
			$repeater->view_search_result();
		}else{
			$repeater->view_search_form();
		}
		
	}
}
?>