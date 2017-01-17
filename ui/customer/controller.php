<?php
namespace ui\customer;
require_once('customerTable.php');
require_once('customerdetail.php');
try
{
	CreateCustomerTable();
	CreateCustomerDetailForm(null);
}catch (Exception $e) {
	echo $e->getMessage();
}

?>