<?php
namespace business\facade;
use business\entity\Reserved;

function insert_reserved(Reserved $r)
{
	global $wpdb;
    $strSql = <<<SQL
		insert into yoyaku_reserved (
			registration_id,
			course_id
		)values(
            '$r->registration_id',
            '$r->course_id'
		)
SQL;
	$wpdb->query($strSql);
}

function get_reserved_by_registration_id($id) : array
{
    $strSql = <<<SQL
            select * from yoyaku_reserved
            where registration_id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		return Reserved::CreateFromWpdb($data);
	}, $result));
	return $ret;
}

function delete_reserved_by_registration_id($id) 
{
    $strSql = <<<SQL
        delete from yoyaku_reserved
        where registration_id = '$id'
SQL;
	global $wpdb;
	$wpdb->query($strSql);
}

?>