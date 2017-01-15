<?php
namespace ui;
function CreaterCustomerTable()
{
	$tableGenerator = new TableGenerator();
	$data = GetCustomerAll();
	$tableGenerator->DataSource = $data;
	$tableGenerator->HeaderDataSource = Customer::GetHeader();
	$tableGenerator->GenerateTable();
}
?>