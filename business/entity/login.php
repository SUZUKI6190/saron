<?php
namespace business\entity;

class Login
{
    public $password;
    public $user_name;
  
	public static function CreateFromWpdb($wpdb) : self
	{
		$data = new self();
		$data->password= $wpdb->password;
		$data->user_name = $wpdb->user_name;
		return $data;
	}  
}

?>