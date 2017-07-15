<?php
namespace business\facade;
use business\entity\ReservedCourse;

function insert_reserved_course(ReservedCourse $r)
{
	global $wpdb;
    $strSql = <<<SQL
		insert into yoyaku_reserved_course (
			registration_id,
			price,
			time_required,
			name
		)values(
            '$r->registration_id',
            '$r->price',
            '$r->time_required',
            '$r->name'
		)
SQL;
	$wpdb->query($strSql);
}

function get_reserved_course_by_registration_id($id) : array
{
    $strSql = <<<SQL
            select * from yoyaku_reserved_course
            where registration_id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		return ReservedCourse::CreateFromWpdb($data);
	}, $result));
	return $ret;
}

function delete_reserved_course_by_registration_id($id) 
{
    $strSql = <<<SQL
        delete from yoyaku_reserved_course
        where registration_id = '$id'
SQL;
	global $wpdb;
	$wpdb->query($strSql);
}

?>