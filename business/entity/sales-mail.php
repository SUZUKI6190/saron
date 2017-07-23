<?php
namespace business\entity;

class SalesMail
{
	public $title;
    public $msg;
    public $price_sum;
    public $per_customer;
    public $sales_num;
    public $send_user_name;
    public $send_user_address;

    public function create_text() : string
    {
        $msg =
        <<<MSG
$this->msg

  売上金額:$this->price_sum
売り上げ数:$this->sales_num
　　客単価:$this->per_customer

MSG;

        return $msg;
    }

    public function create_title() : string
    {
        return $this->title;
    }

	public static function CreateFromWpdb($wpdb) : self
	{
        $ret = new self();
        $ret->title = $wpdb->title;
        $ret->msg = $wpdb->msg;
        $ret->price_sum = $wpdb->price_sum;
        $ret->per_customer = $wpdb->per_customer;
        $ret->sales_num = $wpdb->sales_num;
        $ret->send_user_name = $wpdb->send_user_name;
        $ret->send_user_address = $wpdb->send_user_address;
		return $ret;
	}
}

?>