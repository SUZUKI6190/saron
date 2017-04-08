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
			tell,
			email,
			introduce_page_url
		from
			staff
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
			staff
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
			tell,
			email,
			introduce_page_url
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
			email,
			introduce_page_url
		)values(
			'$staff->id',
			'$staff->name_first',
			'$staff->name_last',
			'$staff->tell',
			'$staff->email',
			'$staff->introduce_page_url'
		)
SQL
);
}

function update_staff_image($id, $mime, $imgdat)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		UPDATE staff SET 
			mime = '$mime',
			imgdat = '$imgdat'
		where id = '$id'
SQL
);
}

?>