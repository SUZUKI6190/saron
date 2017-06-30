<?php
namespace business\entity;

class ReservedCourse
{
	public $id;
	public $price;
	public $time_required;
	public $name;
    public $registration_id;
	public static function CreateFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->price = $wpdb->price;
		$ret->time_required = $wpdb->time_required;
		$ret->name = $wpdb->name;
        $ret->registration_id = $wpdb->registration_id;
		return $ret;
	}
}

?>