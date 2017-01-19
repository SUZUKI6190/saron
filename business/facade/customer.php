<?php
namespace business\facade;
use business\entity\Customer;

function CreateDecQuery($value)
{
	$passWord = "'".Customer::GetPassword()."'";
	
	return "unhex(AES_DECRYPT('$value', $password))";
}	

function GetCustomers()
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
		select
		`id`,
		`tanto_id`,
		convert(AES_DECRYPT(name_kanji_last, '$password') using utf8) as name_kanji_last,
		convert(AES_DECRYPT(name_kanji_first, '$password') using utf8) as name_kanji_first,
		convert(AES_DECRYPT(name_kana_last, '$password') using utf8) as name_kana_last,
		convert(AES_DECRYPT(name_kana_first, '$password') using utf8) as name_kana_first,
		convert(AES_DECRYPT(sex, '$password') using utf8) as sex,
		convert(AES_DECRYPT(old, '$password') using utf8) as old,
		convert(AES_DECRYPT(birthday, '$password') using utf8) as birthday,
		convert(AES_DECRYPT(last_visit_date, '$password') using utf8) as last_visit_date,
		convert(AES_DECRYPT(phone_number, '$password') using utf8) as phone_number
		from customer
SQL;
	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = [];
	foreach($result as $data)
	{
		$c = Customer::CreateObjectFromWpdb($data);
		//print_r($c);
		$ret[] = $c;
	}
	
	return $ret;
	//return array_map('call', $result);
}

function SelectCustomerById($id)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
	SELECT 
		`id`,
		`tanto_id`,
		convert(AES_DECRYPT(name_kanji_last, '$password') using utf8) as name_kanji_last,
		convert(AES_DECRYPT(name_kanji_first, '$password') using utf8) as name_kanji_first,
		convert(AES_DECRYPT(name_kana_last, '$password') using utf8) as name_kana_last,
		convert(AES_DECRYPT(name_kana_first, '$password') using utf8) as name_kana_first,
		convert(AES_DECRYPT(sex, '$password') using utf8) as sex,
		UNHEX(AES_DECRYPT(old, '$password')) as old,
		UNHEX(AES_DECRYPT(birthday, '$password') using utf8) as birthday,
		UNHEX(AES_DECRYPT(last_visit_date, '$password') using utf8) as last_visit_date,
		convert(AES_DECRYPT(phone_number, '$password') using utf8) as phone_number,
		convert(AES_DECRYPT(address, '$password')) as address,
		convert(AES_DECRYPT(occupation, '$password')) as occupation,
		`number_of_visit`,
		convert(AES_DECRYPT(email, '$password')) as email,
		`enable_dm`,
		convert(AES_DECRYPT(next_visit_reservation_date, '$password')) as next_visit_reservation_date,
		convert(AES_DECRYPT(reservation_route, '$password')) as reservation_route,
		convert(AES_DECRYPT(remarks, '$password')) as remarks
	FROM `customer`
	where id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_row($strSql);
	return Customer::CreateObjectFromWpdb($result);
}

function UpdateCustomer(Customer $data)
{
	$passWord = "'".Customer::GetPassword()."'";
	$strSsql = <<<SQL
	update `customer` set
		tanto_id = '$data->tanto_id',
		name_kanji_last = '$data->name_kanji_last',
		name_kanji_first = '$data->name_kanji_first',
		name_kana_last = '$data->name_kana_last',
		name_kana_first = '$data->name_kana_last',
		sex = '$data->sex ',	
		old = '$data->old',
		birthday = '$data->birthday',
		last_visit_date = '$data->last_visit_date',
		phone_number = '$data->phone_number ',
		address = '$data->address',
		occupation = '$data->occupation',
		number_of_visit = '$data->number_of_visit',
		email = '$data->email',
		enable_dm = '$data->enable_dm ',
		next_visit_reservation_date = '$data->next_visit_reservation_date',
		reservation_route = '$data->reservation_route',
		remarks = '$data->remarks'
		where id = '$data->id',
SQL;

	dbDelta($strSql);
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
	AES_ENCRYPT('$data->name_kanji_last', $passWord),
	AES_ENCRYPT('$data->name_kanji_first', $passWord),
	AES_ENCRYPT('$data->name_kana_last', $passWord),
	AES_ENCRYPT('$data->name_kana_first', $passWord),
	AES_ENCRYPT('$data->sex', $passWord),
	AES_ENCRYPT('$data->old', $passWord),
	AES_ENCRYPT('$data->birthday', $passWord),
	AES_ENCRYPT('$data->last_visit_date', $passWord),
	AES_ENCRYPT('$data->phone_number', $passWord),
	AES_ENCRYPT('$data->address', $passWord),
	AES_ENCRYPT('$data->occupation', $passWord),
	'$data->number_of_visit',
	AES_ENCRYPT('$data->email', $passWord),
	'$data->enable_dm',
	AES_ENCRYPT('$data->next_visit_reservation_date', $passWord),
	AES_ENCRYPT('$data->reservation_route', $passWord),
	AES_ENCRYPT('$data->remarks', $passWord)
  )
SQL;
	echo $strSql;
	dbDelta($strSql);
}

?>