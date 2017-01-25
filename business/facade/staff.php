<?php
namespace business\facade;

function get_staff_byid($id)
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last
		from
			staff
		where
			id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	
}

function get_staff_all()
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last
		from
			staff
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	
	$convert = function($data)
	{
		return \business\entity\Staff::CreateFromeWpdb($data);
	};

	return array_map($convert, $result);
}

?>