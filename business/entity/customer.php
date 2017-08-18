<?php
namespace business\entity;
class Customer{
	public $id;
	public $tanto_id;
	public $name_kanji = "";
	public $name_kana = "";
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
	
	public static function create_csv_header()
	{
		$strHeader = "#";
	
		$concat = function($value) use(&$strHeader)
		{
			$strHeader	= $strHeader.$value.",";
		};

		$name_list = [
			"名前(漢字)",
			"名前(かな)",
			"性別",
			"年齢",
			"誕生日",
			"電話番号",
			"住所",
			"職業",
			"来店数",
			"email",
			"DM不可",
			"最終来店日",
			"次回来店予定日",
			"予約経路",
			"備考"
		];

		foreach($name_list as $name)
		{
			$concat($name);	
		}

		$strHeader = rtrim($strHeader, ',');

		return $strHeader;
	}

	public function serialize_csv()
	{
		$strCsv = "";
	
		$concat = function($value) use(&$strCsv)
		{
			$strCsv	= $strCsv.trim($value);
			$strCsv	= $strCsv.",";
		};
		
		$concat($this->name_kanji);
		$concat($this->name_kana);
		$concat($this->sex);
		$concat($this->old);
		$concat($this->birthday);
		$concat($this->phone_number);
		$concat($this->address);
		$concat($this->occupation);
		$concat($this->number_of_visit);
		$concat($this->email);
		$concat($this->enable_dm);
		$concat($this->last_visit_date);
		$concat($this->next_visit_reservation_date);
		$concat($this->reservation_route);
		$concat($this->remarks);

		$strCsv = rtrim($strCsv, ',');
		return $strCsv;
	}
	
	public static function create_csv($obj_list)
	{
		$ret = "";
		foreach($obj_list as $obj)
		{
			$ret = $obj->serialize_csv()."\n";
		}
		$strCsv = rtrim($ret, "\n");
		return $ret;
	}
	
	public static function create_from_csv($csv)
	{
		$index = 0;
		
		$get_value = function() use(&$csv, &$index){
			$temp = $index;
			$index++;
			return $csv[$temp];
		};
		
		$ret = self::CreateEmptyObject();
		
		$ret->name_kanji = $get_value();
		
		if($ret->name_kanji == "")
		{
			return null;
		}
		
		$ret->name_kana = $get_value();
		if($ret->name_kana == "")
		{
			return null;
		}

		$ret->sex = $get_value();
		$ret->old = $get_value();
		$ret->birthday = $get_value();
		$ret->phone_number = $get_value();
		$ret->address = $get_value();
		$ret->occupation = $get_value();
		$ret->number_of_visit = $get_value();
		$ret->email = $get_value();
		$ret->enable_dm = $get_value();
		$ret->last_visit_date = $get_value();
		$ret->next_visit_reservation_date = $get_value();
		$ret->reservation_route = $get_value();
		$ret->remarks = $get_value();
		
		return $ret;
	}
	
	public static function CreateObjectFromWpdb($db)
	{
		$result = Customer::CreateEmptyObject();
		$result->id = $db->id;
		$result->tanto_id = $db->tanto_id;
		$result->name_kanji = $db->name_kanji;
		$result->name_kana = $db->name_kana;
		$result->sex= $db->sex;
		$result->old = $db->old;
		$result->birthday = $db->birthday;
		$result->last_visit_date = $db->last_visit_date;
		$result->phone_number= $db->phone_number;
		//一覧表示時はここまでしかselectしていない
		if(!property_exists( $db, 'address'))
		{
			return $result;
		}
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