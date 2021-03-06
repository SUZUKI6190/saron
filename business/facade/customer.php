<?php
namespace business\facade;
use business\entity\Customer;
use business\entity\Config;

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


function select_customer_id_and_visitnum_by_email($email)
{
	$password = Customer::GetPassword();
	$strSql = <<<SQL
	SELECT 
		`id`,
		`number_of_visit`
	FROM `yoyaku_customer`
	where convert(AES_DECRYPT(email, '$password')  using utf8) = '$email'
SQL;

	global $wpdb;
	$result = $wpdb->get_row($strSql);

	$ret = new class(){};
	if(is_null($result)){
		return null;
	}else{
		$ret->id = $result->id;
		$ret->number_of_visit = $result->number_of_visit;
		return $ret;
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
	
	if(is_null($result)){
		return null;
	}else{
		return Customer::CreateObjectFromWpdb($result);
	}
}

function UpdateCustomer(Customer $data)
{
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
	update `yoyaku_customer` set
		tanto_id = '$data->tanto_id',
		name_kanji = AES_ENCRYPT(trim('$data->name_kanji'), $passWord),
		name_kana = AES_ENCRYPT(trim('$data->name_kana'), $passWord),
		sex = AES_ENCRYPT(trim('$data->sex'), $passWord),
		old = AES_ENCRYPT(trim('$data->old'), $passWord),
		birthday = AES_ENCRYPT(trim('$data->birthday'), $passWord),
		last_visit_date = AES_ENCRYPT(trim('$data->last_visit_date'), $passWord),
		phone_number = AES_ENCRYPT(trim('$data->phone_number'), $passWord),
		address = AES_ENCRYPT(trim('$data->address'), $passWord),
		occupation = AES_ENCRYPT(trim('$data->occupation'), $passWord),
		number_of_visit = '$data->number_of_visit',
		email = AES_ENCRYPT(trim('$data->email'), $passWord),
		enable_dm = '$data->enable_dm',
		next_visit_reservation_date = AES_ENCRYPT(trim('$data->next_visit_reservation_date'), $passWord),
		reservation_route = AES_ENCRYPT(trim('$data->reservation_route'), $passWord),
		remarks = AES_ENCRYPT(trim('$data->remarks'), $passWord)
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

function delete_customer_by_last_visit_date()
{
	global $wpdb;
	$passWord = Customer::GetPassword();
	$interval_id = Config::IntervalDeleateCustomersId;
	$wpdb->query(
	<<<SQL
	delete from	yoyaku_customer
	where (convert(AES_DECRYPT(last_visit_date, '$passWord')  using utf8) + interval (select value from yoyaku_config where id ='$interval_id') month) <= now()
SQL
);
}

function customer_update_from_yoyakumail(int $id, Customer $data)
{
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
	update `yoyaku_customer` set
		tanto_id = trim('$data->tanto_id'),
		name_kanji = AES_ENCRYPT(trim('$data->name_kanji'), $passWord),
		name_kana = AES_ENCRYPT(trim('$data->name_kana'), $passWord),
		phone_number = AES_ENCRYPT(trim('$data->phone_number'), $passWord),
		email = AES_ENCRYPT(trim('$data->email'), $passWord),
		remarks = AES_ENCRYPT(trim('$data->remarks'), $passWord),
		last_visit_date = next_visit_reservation_date,
		reservation_route = AES_ENCRYPT(trim('$data->reservation_route'), $passWord), 
		next_visit_reservation_date = AES_ENCRYPT(trim('$data->next_visit_reservation_date'), $passWord),
		remarks = AES_ENCRYPT(trim('$data->remarks'), $passWord),
		number_of_visit = '$data->number_of_visit'
	where id = '$id'
SQL;

	global $wpdb;
	$wpdb->query($strSql);	
}

function update_nextvisit(int $id,  \DateTime $next_day)
{
	$strDate = $next_day->format('Ymd');
	$passWord = "'".Customer::GetPassword()."'";
	$strSql = <<<SQL
	update `yoyaku_customer` set
		next_visit_reservation_date = AES_ENCRYPT(trim('$strDate'), $passWord)
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
	AES_ENCRYPT(trim('$data->name_kanji'), $passWord),
	AES_ENCRYPT(trim('$data->name_kana'), $passWord),
	AES_ENCRYPT(trim('$data->sex'), $passWord),
	AES_ENCRYPT(trim('$data->old'), $passWord),
	AES_ENCRYPT(trim('$data->birthday'), $passWord),
	AES_ENCRYPT(trim('$data->last_visit_date'), $passWord),
	AES_ENCRYPT(trim('$data->phone_number'), $passWord),
	AES_ENCRYPT(trim('$data->address'), $passWord),
	AES_ENCRYPT(trim('$data->occupation'), $passWord),
	'$data->number_of_visit',
	AES_ENCRYPT(trim('$data->email'), $passWord),
	'$data->enable_dm',
	AES_ENCRYPT(trim('$data->next_visit_reservation_date'), $passWord),
	AES_ENCRYPT(trim('$data->reservation_route'), $passWord),
	AES_ENCRYPT(trim('$data->remarks'), $passWord)
  )
SQL;
	dbDelta($strSql);
}


?>