<?php
namespace business\entity;

class Staff
{
	public $id;
	public $name_last;
	public $name_first;
	public $tell;
	public $email;
	public $imgdat;
	public $mine;
	public $introduce_page_url;
	
	public static function get_empty_object():Staff
	{
		return new Staff();
	}
	
	public static function CreateFromWpdb($wpdb)
	{
		$data = new Staff();
		$data->id = $wpdb->id;
		$data->name_last = $wpdb->name_last;
		$data->name_first= $wpdb->name_first;
		$data->tell = $wpdb->tell;
		$data->email = $wpdb->email;
		$data->introduce_page_url = $wpdb->introduce_page_url;
		return $data;
	}
}

?>