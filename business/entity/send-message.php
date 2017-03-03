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
	public $occupation;
	public $reservation_route;

	public static function get_empty_object():SendMessage
	{
		return new SendMessage();
	}
	
	public static function CreateFromWpdb($wpdb)
	{
		$data = new SendMessage();
		$data->id = $wpdb->id;
		$data->title = $wpdb->title;
		$data->birth = $wpdb->birth;
		$data->last_visit = $wpdb->last_visit;
		$data->next_visit = $wpdb->next_visit;
		$data->enable_dm = $wpdb->enable_dm;
		$data->sending_mail = $wpdb->sending_mail;
		$data->confirm_mail = $wpdb->confirm_mail;
		$data->message_text = $wpdb->message_text;
		$data->sex = $wpdb->sex;
		$data->visit_num = $wpdb->visit_num;
		$data->staff_id = $wpdb->staff_id;
		$data->occupation = $wpdb->occupation;
		$data->reservation_route = $wpdb->reservation_route;

		return $data;
	}
}

?>