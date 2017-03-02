<?php
namespace business\facade;
use \business\entity\SendMessage;

function get_message_setting_byid($id) : SendMessage
{
	$strSql = <<<SQL
		select
			*
		from
			sending_message
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
			sending_message
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
		delete from sending_message
		where id = '$id'
SQL
);
}

function insert_message_setting($msg)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into sending_message (
			id,
			title,
			birth,
			last_visit,
			next_visit,
			enable_dm,
			sending_mail,
			confirm_mail,
			message_text,
			sex,
			visit_num,
			staff_id,
			)values(
			'$msg->id',
			'$msg->title',
			'$msg->birth',
			'$msg->lastvisit',
			'$msg->next_visit',
			'$msg->enable_dm',
			'$msg->sending_mail',
			'$msg->confirm_mail',
			'$msg->message_text',
			'$msg->sex',
			'$msg->visit_num',
			'$msg->staff_id',
		)
SQL
);
}

?>