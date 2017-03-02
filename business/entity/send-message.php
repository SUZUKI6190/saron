<?php
namespace business\entity;

class SendMessage
{
	public $id;
	public $title;
	public $birth;
	public $last_visit;
	public $next_visit;
	public $enable_dm;
	public $sending_mail;
	public $confirm_mail;
	public $message_text;
	public $sex;
	public $visit_num;
	public $staff_id;
	
	public static function get_empty_object():Staff
	{
		return new SendMessage();
	}
	
	public static function CreateFromWpdb($wpdb)
	{
		$data = new SendMessage();
		$data->id = $wpdb->id;
		$data->name_last = $wpdb->name_last;
		$data->name_first= $wpdb->name_first;
		$data->tell = $wpdb->tell;
		$data->email = $wpdb->email;
		
		return $data;
	}
}

?>