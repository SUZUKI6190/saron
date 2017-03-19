<?php
namespace business\entity;

class Sales
{
	public $day;
	public $sales;
	public $per_customer_price;
	public $number_of_customers_new;
	public $number_of_customers_repeater;
	
	public static function CreateFromWpdb($wpdb) : Sales
	{
		$ret = new Sales();
		$this->day = $wpdb->day;
		$this->sales= $wpdb->sales;
		$this->per_customer_price = $wpdb->per_customer_price;
		$this->number_of_customers_new = $wpdb->number_of_customers_new;
		$this->number_of_customers_repeater = $wpdb->number_of_customers_repeater;
		
		return $ret;
	}
}

?>