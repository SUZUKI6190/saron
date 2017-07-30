<?php
namespace business\facade;
use business\entity\Sold;

function insert_reserved_sold(Sold $r)
{
	global $wpdb;
    $strSql = <<<SQL
		insert into yoyaku_sold (
			registration_id,
            name,
            price
  		)values(
            '$r->registration_id',
            '$r->name',
            '$r->price'
		)
SQL;
	$wpdb->query($strSql);
}

function get_sold_by_registration_id($id) : array
{
    $strSql = <<<SQL
            select * from yoyaku_sold
            where registration_id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		return Sold::CreateFromWpdb($data);
	}, $result));
	return $ret;
}

function delete_sold_by_registration_id($id) 
{
    $strSql = <<<SQL
        delete from yoyaku_sold
        where registration_id = '$id'
SQL;
	global $wpdb;
	$wpdb->query($strSql);
}

?>