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

function InsertCustomer(Customer $data)
{
	global $wpdb;
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
INSERT INTO `customer` (
	tanto_id,
	name_kanji_last,
	name_kanji_first,
	name_kana_last,
	name_kana_first,
	sex,	
	old,
	birthday,
	last_visit_date,
	phone_number,
	address,
	occupation,
	number_of_visit,
	email,
	enable_dm,
	next_visit_reservation_date,
	reservation_route,
	remarks
	)
  VALUES (
	'$data->tanto_id',
	'$data->name_kanji_last',
	'$data->name_kanji_first',
	'$data->name_kana_last',
	'$data->name_kana_first',
	'$data->sex',
	'$data->old',
	AES_ENCRYPT('$data->birthday', $passWord),
	AES_ENCRYPT('$data->last_visit_date', $passWord),
	AES_ENCRYPT('$data->phone_number', $passWord),
	AES_ENCRYPT('$data->address', $passWord),
	'$data->occupation',
	'$data->number_of_visit',
	AES_ENCRYPT('$data->email', $passWord),
	'$data->enable_dm',
	AES_ENCRYPT('$data->next_visit_reservation_date', $passWord),
	AES_ENCRYPT('$data->reservation_route', $passWord),
	AES_ENCRYPT('$data->remarks', $passWord)
  )
SQL;

	dbDelta($strSql);
}

?>