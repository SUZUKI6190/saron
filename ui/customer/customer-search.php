<?php
namespace ui\customer;
require_once('customer-search-factory.php');
require_once('customer-search-item.php');
function view_search(ControlContext $c)
{
	$item = [];
	$item[] = CustomerSearchItemFactory::create_kanjiname();
	$item[] = CustomerSearchItemFactory::create_kananame();
	$repeater = new SearchitemRepeater($item, $c);
	
	if($c->SearchResult == "result"){
		$repeater->view_search_result();
	}else{
		$repeater->view_search_form();
	}
}

?>