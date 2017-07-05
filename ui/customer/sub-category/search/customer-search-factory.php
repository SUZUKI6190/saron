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
	
	public static function create_enable_dm()
	{
		return new EnabeleDMItem();
	}
	
	public static function create_last_visit_item()
	{
		return new LastVisitItem();
	}
	public static function create_next_visit_reservation_item()
	{
		return new NextVisitItem();
	}
}

?>