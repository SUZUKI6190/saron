<?php
namespace ui\customer;
require_once('customer-search-factory.php');
require_once('customer-search-item.php');
function view_search(ControlContext $c)
{
	$item = [
		CustomerSearchItemFactory::create_kanjiname(),
		CustomerSearchItemFactory::create_kananame(),
		CustomerSearchItemFactory::create_phonenum(),
		CustomerSearchItemFactory::create_email(),
		CustomerSearchItemFactory::create_old(),
				CustomerSearchItemFactory::create_sex()

	];
	$repeater = new SearchitemRepeater($item, $c);
	
	if($c->SearchResult == "result"){
		$repeater->view_search_result();
	}else{
		$repeater->view_search_form();
	}
}

?>