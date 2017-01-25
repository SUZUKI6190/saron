<?php
namespace business\entity;

class Staff
{
	public $id;
	public $name_last;
	public $name_first;
	
	public static function CreateFromeWpdb($wpdb)
	{
		$data = new Staff();
		$data->id = $wpdb->id;
		$data->name_last = $wpdb->name_last;
		$data->name_first= $wpdb->name_first;
		return $data;
	}
}

?>