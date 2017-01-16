<?php
namespace data;
use data\entity;
function InsertCustomer(Customer $data)
{
	$strSql = <<<SQL
INSERT INTO `Customer` (
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
	remarks,
	)
  VALUES (
	$data->name_kanji_last,
	$data->name_kanji_first,
	$data->name_kana_last,
	$data->name_kana_first,
	$data->sex,
	$data->old,
	AES_ENCRYPT($data->birthday, Customer::GetPassword),
	AES_ENCRYPT($data->last_visit_date, Customer::GetPassword),
	AES_ENCRYPT($data->phone_number, Customer::GetPassword),
	AES_ENCRYPT($data->address, Customer::GetPassword),
	$data->occupation,
	$data->number_of_visit,
	AES_ENCRYPT($data->email, Customer::GetPassword),
	$data->enable_dm,
	AES_ENCRYPT($data->next_visit_reservation_date, Customer::GetPassword),
	AES_ENCRYPT($data->reservation_route, Customer::GetPassword),
	AES_ENCRYPT($data->remarks, Customer::GetPassword)
  )
  
SQL;

	return $strSql;
}
?>