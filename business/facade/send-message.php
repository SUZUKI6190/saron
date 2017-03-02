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
		insert into staff (
			id,
			name_first,
			name_last,
			tell,
			email
		)values(
			'$staff->id',
			'$staff->name_first',
			'$staff->name_last',
			'$staff->tell',
			'$staff->email'
		)
SQL
);
}

?>