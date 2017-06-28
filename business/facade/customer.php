<?php
namespace business\facade;
require_once(dirname(__FILE__).'/../entity/customer_interval_setting.php');
use business\entity\Customer;
use business\entity\CostomerIntervalSetting;

function CreateDecQuery($value)
{
	$passWord = "'".Customer::GetPassword()."'";
	
	return "unhex(AES_DECRYPT('$value', $password))";
}	

function GetCustomers( $strWhere)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
		select
		`id`,
		`tanto_id`,
		convert(AES_DECRYPT(name_kanji, '$password') using utf8) as name_kanji,
		convert(AES_DECRYPT(name_kana, '$password') using utf8) as name_kana,
		convert(AES_DECRYPT(sex, '$password') using utf8) as sex,
		convert(AES_DECRYPT(old, '$password') using utf8) as old,
		convert(AES_DECRYPT(birthday, '$password') using utf8) as birthday,
		convert(AES_DECRYPT(last_visit_date, '$password') using utf8) as last_visit_date,
		convert(AES_DECRYPT(phone_number, '$password') using utf8) as phone_number
		from yoyaku_customer
		$strWhere
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

function select_customer_by_email($email)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
	SELECT 
		`id`,
		`tanto_id`,
		convert(AES_DECRYPT(name_kanji, '$password') using utf8) as name_kanji,
		convert(AES_DECRYPT(name_kana, '$password') using utf8) as name_kana,
		convert(AES_DECRYPT(sex, '$password') using utf8) as sex,
		convert(AES_DECRYPT(old, '$password') using utf8) as old,
		convert(AES_DECRYPT(birthday, '$password') using utf8) as birthday,
		convert(AES_DECRYPT(last_visit_date, '$password') using utf8) as last_visit_date,
		convert(AES_DECRYPT(phone_number, '$password') using utf8) as phone_number,
		convert(AES_DECRYPT(address, '$password')  using utf8) as address,
		convert(AES_DECRYPT(occupation, '$password')  using utf8) as occupation,
		`number_of_visit`,
		convert(AES_DECRYPT(email, '$password')  using utf8) as email,
		`enable_dm`,
		convert(AES_DECRYPT(next_visit_reservation_date, '$password')  using utf8) as next_visit_reservation_date,
		convert(AES_DECRYPT(reservation_route, '$password')  using utf8) as reservation_route,
		convert(AES_DECRYPT(remarks, '$password')  using utf8) as remarks
	FROM `yoyaku_customer`
	where convert(AES_DECRYPT(email, '$password')  using utf8) = '$email'
SQL;

	global $wpdb;
	$result = $wpdb->get_row($strSql);
	if(is_null($result)){
		return null;
	}else{
		return Customer::CreateObjectFromWpdb($result);
	}
}


function select_customer_id_by_email($email)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
	SELECT 
		`id`
	FROM `yoyaku_customer`
	where convert(AES_DECRYPT(email, '$password')  using utf8) = '$email'
SQL;

	global $wpdb;
	$result = $wpdb->get_row($strSql);
	if(is_null($result)){
		return null;
	}else{
		return $result->id;
	}
}


function SelectCustomerById($id)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
	SELECT 
		`id`,
		`tanto_id`,
		convert(AES_DECRYPT(name_kanji, '$password') using utf8) as name_kanji,
		convert(AES_DECRYPT(name_kana, '$password') using utf8) as name_kana,
		convert(AES_DECRYPT(sex, '$password') using utf8) as sex,
		convert(AES_DECRYPT(old, '$password') using utf8) as old,
		convert(AES_DECRYPT(birthday, '$password') using utf8) as birthday,
		convert(AES_DECRYPT(last_visit_date, '$password') using utf8) as last_visit_date,
		convert(AES_DECRYPT(phone_number, '$password') using utf8) as phone_number,
		convert(AES_DECRYPT(address, '$password')  using utf8) as address,
		convert(AES_DECRYPT(occupation, '$password')  using utf8) as occupation,
		`number_of_visit`,
		convert(AES_DECRYPT(email, '$password')  using utf8) as email,
		`enable_dm`,
		convert(AES_DECRYPT(next_visit_reservation_date, '$password')  using utf8) as next_visit_reservation_date,
		convert(AES_DECRYPT(reservation_route, '$password')  using utf8) as reservation_route,
		convert(AES_DECRYPT(remarks, '$password')  using utf8) as remarks
	FROM `yoyaku_customer`
	where id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_row($strSql);
	return Customer::CreateObjectFromWpdb($result);
}

function UpdateCustomer(Customer $data)
{
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
	update `yoyaku_customer` set
		tanto_id = '$data->tanto_id',
		name_kanji = AES_ENCRYPT('$data->name_kanji', $passWord),
		name_kana = AES_ENCRYPT('$data->name_kana', $passWord),
		sex = AES_ENCRYPT('$data->sex',	 $passWord),
		old = AES_ENCRYPT('$data->old', $passWord),
		birthday = AES_ENCRYPT('$data->birthday', $passWord),
		last_visit_date = AES_ENCRYPT('$data->last_visit_date', $passWord),
		phone_number = AES_ENCRYPT('$data->phone_number ', $passWord),
		address = AES_ENCRYPT('$data->address', $passWord),
		occupation = AES_ENCRYPT('$data->occupation', $passWord),
		number_of_visit = '$data->number_of_visit',
		email = AES_ENCRYPT('$data->email', $passWord),
		enable_dm = '$data->enable_dm',
		next_visit_reservation_date = AES_ENCRYPT('$data->next_visit_reservation_date', $passWord),
		reservation_route = AES_ENCRYPT('$data->reservation_route', $passWord),
		remarks = AES_ENCRYPT('$data->remarks', $passWord)
	where id = '$data->id'
SQL;
	
	global $wpdb;
	$wpdb->query($strSql);
}

function delete_customer_byid($id)
{
	global $wpdb;
	$wpdb->query(
	<<<SQL
	DELETE FROM	yoyaku_customer
	WHERE id = '$id'
SQL
);
}

function delete_customer_by_last_visit_date($lapsed_month)
{
	global $wpdb;
	$wpdb->query(
	<<<SQL
	DELETE FROM	yoyaku_customer
	WHERE now() > (convert(AES_DECRYPT(last_visit_date, 'password') using utf8) + INTERVAL $lapsed_month MONTH)
SQL
);
}

function update_nextvisit(int $id,  \DateTime $next_day)
{
	$strDate = $next_day->format('Ymd');
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
	update `yoyaku_customer` set
		next_visit_reservation_date = AES_ENCRYPT('$strDate', $passWord)
	where id = '$id'
SQL;
	global $wpdb;
	$wpdb->query($strSql);	
}

function InsertCustomer(Customer $data)
{
	global $wpdb;
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
INSERT INTO `yoyaku_customer` (
	tanto_id,
	name_kanji,
	name_kana,
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
	AES_ENCRYPT('$data->name_kanji', $passWord),
	AES_ENCRYPT('$data->name_kana', $passWord),
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
	dbDelta($strSql);
}

function set_customer_interval_setting(\business\entity\CustomerIntervalSetting $cis)
{
	global $wpdb;
	$id = $cis->id;
	$value = $cis->value;
	$wpdb->query(
	<<<SQL
	DELETE FROM	customer_interval_setting
	WHERE id = '$id'
SQL
);
	$wpdb->query(
	<<<SQL
	INSERT INTO	customer_interval_setting
	(
	id,
	value
	)
	values (
		'$id',
		'$value'
	)
SQL
);
}

function get_interval_setting_byid($id) : string
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
		select
			value
		from customer_interval_setting
		where id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	if(count($result) > 0){
		return $result[0]->value;
	}else{
		return "";
	}

}

?>