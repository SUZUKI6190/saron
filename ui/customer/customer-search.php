<?php
namespace ui\customer;
require_once('customer-search-factory.php');
require_once('customer-search-item.php');
function view_search(ControlContext $c)
{
	$item_1 = [
		CustomerSearchItemFactory::create_kanjiname(),
		CustomerSearchItemFactory::create_kananame(),
		CustomerSearchItemFactory::create_phonenum(),
		CustomerSearchItemFactory::create_email(),
		CustomerSearchItemFactory::create_old(),
		CustomerSearchItemFactory::create_sex()
	];
	
	$item_2 = [
		CustomerSearchItemFactory::create_birthday(),
		CustomerSearchItemFactory::create_occupation(),
		CustomerSearchItemFactory::create_last_visit_item(),
		CustomerSearchItemFactory::create_next_visit_reservation_item(),
		CustomerSearchItemFactory::create_enable_dm()
	];

	$item = [$item_1, $item_2];
	$repeater = new SearchitemRepeater($item, $c);
	
	if($c->SearchResult == "result"){
		$repeater->view_search_result();
	}else{
		$repeater->view_search_form();
	}
}

?>