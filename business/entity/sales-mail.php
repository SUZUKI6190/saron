<?php
namespace business\entity;

class SalesMail
{
	public $title;
    public $msg;
    public $price_sum;
    public $per_customer;
    public $sales_num;

	public static function CreateFromWpdb($wpdb) : self
	{
        $ret = new self();
        $ret->title = $wpdb->title;
        $ret->msg = $wpdb->msg;
        $ret->price_sum = $wpdb->price_sum;
        $ret->per_customer = $wpdb->per_customer;
        $ret->sales_num = $wpdb->sales_num;
		return $ret;
	}
}

?>