<?php
namespace business\entity;

class SalesMail
{
	public $id;
	public $email;
	
	public static function CreateFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->email = $wpdb->email;
		return $ret;
	}
}

?>