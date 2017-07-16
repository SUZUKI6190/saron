<?php
namespace business\entity;

class SalesMail
{
	public $id;
	public $email;
	
	public static function CreateObjectFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->email = $wpdb->email;
		return $ret;
	}
}

?>