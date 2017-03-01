<?php
namespace business\facade;
use \business\entity\Staff;

function get_staff_byid($id) : Staff
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last,
			tell,
			email
		from
			staff
		where
			id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	return Staff::CreateFromWpdb($result[0]);
}

function get_staff_all()
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last,
			tell,
			email
		from
			staff
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	
	$convert = function($data)
	{
		return Staff::CreateFromWpdb($data);
	};

	return array_map($convert, $result);
}

function delete_staff($id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from staff
		where id = '$id'
SQL
);
}

function insert_staff($staff)
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