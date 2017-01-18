<?php
namespace business\entity;
class Customer{
	public $id;
	public $tanto_id;
	public $name_kanji_last = "";
	public $name_kanji_first = "";
	public $name_kana_last = "";
	public $name_kana_first = "";
	public $sex = "";
	public $old = 0;
	public $birthday = "";
	public $last_visit_date = "";
	public $phone_number = "";
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