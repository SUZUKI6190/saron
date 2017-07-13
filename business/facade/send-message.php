<?php
namespace business\facade;
use \business\entity\SendMessage;

function get_message_setting_byid($id) : SendMessage
{
	$strSql = <<<SQL
		select
			*
		from
			yoyaku_sending_message
		where
			id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	return SendMessage::CreateFromWpdb($result[0]);
}

function get_message_setting_all()
{
	$strSql = <<<SQL
		select
			*
		from
			yoyaku_sending_message
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	
	$convert = function($data)
	{
		return SendMessage::CreateFromWpdb($data);
	};

	return array_map($convert, $result);
}

function delete_message_setting($id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from yoyaku_sending_message
		where id = '$id'
SQL
);
}

function insert_message_setting($msg)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_sending_message (
			title,
			birth,
			last_visit,
			next_visit,
			enable_dm,
			sending_mail,
			confirm_mail,
			message_text,
			sex,
			visit_num_more,
			visit_num_less,
			staff_id,
			occupation,
			reservation_route
			)values(
			nullif('$msg->title', ''),
			nullif('$msg->birth', ''),
			nullif('$msg->last_visit', ''),
			nullif('$msg->next_visit', ''),
			nullif('$msg->enable_dm', ''),
			nullif('$msg->sending_mail', ''),
			nullif('$msg->confirm_mail', ''),
			nullif('$msg->message_text', ''),
			nullif('$msg->sex', ''),
			nullif('$msg->visit_num_more', ''),
			nullif('$msg->visit_num_less', ''),
			nullif('$msg->staff_id', ''),
			nullif('$msg->occupation', ''),
			nullif('$msg->reservation_route', '')
		)
SQL
);
}

function update_message_setting(SendMessage $msg)
{
	global $wpdb;
	$s = <<<SQL
		update yoyaku_sending_message  set
			title = nullif('$msg->title', ''),
			birth = nullif('$msg->birth', ''),
			last_visit = nullif('$msg->last_visit', ''),
			next_visit = nullif('$msg->next_visit', ''),
			enable_dm = nullif('$msg->enable_dm', ''),
			sending_mail = nullif('$msg->sending_mail', ''),
			confirm_mail = nullif('$msg->confirm_mail', ''),
			message_text = nullif('$msg->message_text', ''),
			sex = nullif('$msg->sex', ''),
			staff_id = nullif('$msg->staff_id', ''),
			visit_num_more = nullif('$msg->visit_num_more', ''),
			visit_num_less = nullif('$msg->visit_num_less', ''),
			occupation = nullif('$msg->occupation', ''),
			reservation_route = nullif('$msg->reservation_route', '')
		where id = '$msg->id'
SQL;

	$wpdb->query($s);
}

?>