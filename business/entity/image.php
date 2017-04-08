<?php
namespace business\entity;

class Image
{
	public $imgdat;
	public $mime;

	public static function CreateFromWpdb($wpdb) : Image
	{
		$data = new Image();
		$data->imgdat = $wpdb->imgdat;
		$data->mime = $wpdb->mime;
		return $data;
	}
}

?>