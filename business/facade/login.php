<?php
namespace business\facade;
use \business\entity\Login;

function check_login_password(string $name, string $pass) : bool
{
	$strSql = <<<SQL
		select
            password
		from
			yoyaku_login
        where
            user_name = '$name'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	
    if(count($result) == 0)
    {
        return false;
    }

	return $reult[0]->password == $pass;

}

?>