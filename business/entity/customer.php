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
	public $occupation = "";
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
	
	public static function CreateObjectFromWpdb($db)
	{
		$result = Customer::CreateEmptyObject();
		$result->id = $db->id;
		$result->tanto_id = $db->tanto_id;
		$result->name_kanji_last = $db->name_kanji_last;
		$result->name_kanji_first = $db->name_kanji_first;
		$result->name_kana_last = $db->name_kana_last;
		$result->name_kana_first = $db->name_kana_first;
		$result->sex= $db->sex;
		$result->old = $db->old;
		$result->birthday = $db->birthday;
		$result->last_visit_date = $db->last_visit_date;
		$result->phone_number= $db->phone_number;
		$result->address = $db->address;
		$result->occupation = $db->occupation;
		$result->number_of_visit =  $db->number_of_visit;
		$result->email = $db->email;
		$result->enable_dm = $db->enable_dm;
		$result->next_visit_reservation_date = $db->next_visit_reservation_date;
		$result->reservation_route = $db->reservation_route;
		$result->remarks = $db->remarks;
		return $result;
	}
}
?>