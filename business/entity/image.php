<?php
namespace business\entity;

class Image
{
	public $imgdat;
	public $mine;

	public static function CreateFromWpdb($wpdb) : Image
	{
		$data = new Image();
		$data->imgdat = $wpdb->imgdat;
		$data->mine = $wpdb->mine;
		return $data;
	}
}

?>