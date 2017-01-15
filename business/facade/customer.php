<?php
namespace business\facade;
use business\entity\Customer;
function GetCustomerAll()
{
	$test1 = new Customer();
	$test1->name_kana_last = "aaa";
	$test2 = new Customer();
	return [$test1,$test2];
}
?>