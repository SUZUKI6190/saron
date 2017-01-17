<?php
namespace business\entity;
class Customer{
	public $id;
	public $tanto_id;
	public $name_kanji_last = "tesssssssst1t1";
	public $name_kanji_first = "test1";
	public $name_kana_last = "test1";
	public $name_kana_first = "test1";
	public $sex = "";
	public $old = 12;
	public $birthday = "";
	public $last_visit_date = "";
	public $phone_number = "000000";
	public $address = "";
	public $occupation = "ss";
	public $number_of_visit = 0;
	public $staff = "";
	public $email = "";
	public $enable_dm = 0;
	public $next_visit_reservation_date = "";
	public $reservation_route = "";
	public $remarks = "";

	public static function GetPassword()
	{
		return "password";
	}
	
	public static function CreateEmptyObject()
	{
		return new Customer();
	}
}
?>