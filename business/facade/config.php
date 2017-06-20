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


?>