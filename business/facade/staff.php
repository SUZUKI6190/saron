<?php
namespace business\facade;
use \business\entity\Staff;
use \business\entity\Image;

function get_staff_byid($id) : Staff
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last,
			introduce_page_url
		from
			yoyaku_staff
		where
			id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	return Staff::CreateFromWpdb($result[0]);
}

function get_staff_image_by_id($id) : Image
{
		$strSql = <<<SQL
		select
			`imgdat`,
			`mime`
		from
			yoyaku_staff
		where
			id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	return Image::CreateFromWpdb($result[0]);
}

function get_staff_all()
{
	$strSql = <<<SQL
		select
			id,
			name_first,
			name_last,
			introduce_page_url
		from
			yoyaku_staff
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
		delete from yoyaku_staff
		where id = '$id'
SQL
);
}

function insert_staff($staff)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_staff (
			id,
			name_first,
			name_last,
			introduce_page_url
		)values(
			'$staff->id',
			'$staff->name_first',
			'$staff->name_last',
			'$staff->introduce_page_url'
		)
SQL
);
}


function insert_staff_with_image($staff)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_staff (
			id,
			name_first,
			name_last,
			introduce_page_url,
			mime,
			imgdat
		)values(
			'$staff->id',
			'$staff->name_first',
			'$staff->name_last',
			'$staff->introduce_page_url',
			'$staff->mime',
			'$staff->imgdat'
		)
SQL
);
}

function update_staff($staff)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		UPDATE yoyaku_staff SET 
			name_first = '$staff->name_first',
			name_last= '$staff->name_last',
			introduce_page_url = '$staff->introduce_page_url'
		where id = '$staff->id'
SQL
);
}

function update_staff_image($id, $mime, $imgdat)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		UPDATE yoyaku_staff SET 
			mime = '$mime',
			imgdat = '$imgdat'
		where id = '$id'
SQL
);
}

?>