<?php
namespace ui\customer;

require_once('customer-search-item.php');
require_once('customer-search-criteria.php');


class CustomerSearchItemFactory
{
	public static function create_kanjiname()
	{
			return new KanjiNameItem();
	}
	
	public static function create_kananame()
	{
			return new KanaNameItem();
	}
	
	public static function create_phonenum()
	{
		return new PhoneNumItem();
	}
	
	public static function create_email()
	{
		return new EmailItem();
	}
	
	public static function create_old()
	{
		return new OldItem();
	}
	
	public static function create_sex()
	{
		return new SexItem();
	}
	
	public static function create_birthday()
	{
		return new BirthdayItem();
	}
	
	public static function create_occupation()
	{
		return new OccupationItem();
	}
}

?>