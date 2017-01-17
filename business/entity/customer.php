<?php
namespace business\entity;
class Customer{
	public $id;
	public $tanto_id;
	public $name_kanji_last = "test1";
	public $name_kanji_first = "test1";
	public $name_kana_last = "test1";
	public $name_kana_first = "test1";
	public $sex = "";
	public $old;
	public $birthday;
	public $last_visit_date;
	public $phone_number;
	public $address;
	public $occupation;
	public $number_of_visit;
	public $staff;
	public $email;
	public $enable_dm;
	public $next_visit_reservation_date;
	public $reservation_route;
	public $remarks;

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