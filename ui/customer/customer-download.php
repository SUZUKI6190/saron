<?php
namespace ui\customer;
class CustomerDownload
{
	const CUSTOMER_ID_NAME = "key_value_list";
}
function get_customer_csv($csv)
{

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=data.csv');
	header("Content-type: text/html; charset=utf-8");
	$id_list = str_getcsv( $_POST[CustomerDownload::CUSTOMER_ID_NAME]);
	
	$ret = "";
	
	foreach($id_list as $id)
	{
		$ret=  $ret.\business\facade\SelectCustomerById($id)->serialize_csv()."\n";
	}

	$stream = fopen('php://output', 'w');

	fputcsv($stream, str_getcsv($ret));
	
}

?>