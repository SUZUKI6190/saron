<?php
namespace business\facade;
use business\entity\Config;

function get_config(Config $new_c)
{
	$strSql = <<<SQL
		select
            *
		from
			yoyaku_config
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
       
    foreach($result as $r)
    {
        $new_c->set_value($r->id , $r->value);
    }

}

function set_config(int $id, string $value)
{
    delete_config($id);
    insert_config($id, $value);
}

function delete_config(int $id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from yoyaku_config
		where id = '$id'
SQL
);
}

function insert_config($id, $value)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_config (
			id,
            value
		)values(
			'$id',
			'$value'
		)
SQL
);
}



?>