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
			'$msg->title',
			'$msg->birth',
			'$msg->last_visit',
			'$msg->next_visit',
			'$msg->enable_dm',
			'$msg->sending_mail',
			'$msg->confirm_mail',
			'$msg->message_text',
			'$msg->sex',
			'$msg->visit_num_more',
			'$msg->visit_num_less',
			'$msg->staff_id',
			'$msg->occupation',
			'$msg->reservation_route'
		)
SQL
);
}

function update_message_setting(SendMessage $msg)
{
	global $wpdb;
	$s = <<<SQL
		update yoyaku_sending_message  set
			title = '$msg->title',
			birth = '$msg->birth',
			last_visit = '$msg->last_visit',
			next_visit = '$msg->next_visit',
			enable_dm = '$msg->enable_dm',
			sending_mail = '$msg->sending_mail',
			confirm_mail = '$msg->confirm_mail',
			message_text = '$msg->message_text',
			sex = '$msg->sex',
			visit_num_more = '$msg->visit_num_more',
			visit_num_less = '$msg->visit_num_less',
			occupation = '$msg->occupation',
			reservation_route = '$msg->reservation_route'
		where id = '$msg->id'
SQL;

	$wpdb->query($s);
}


?>