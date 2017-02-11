<?php
namespace ui\customer;
use business\entity\Customer;
require_once("customer-detail-item.php");

function  create_item_list(Customer $c)
{
	return [
		new KanjiNameDetailItem($c)
	];
}

?>