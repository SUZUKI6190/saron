<?php
namespace business\facade;

class RegistSold
{
    private function __construct(){}

    public static function RegistSold()
    {
	global $wpdb;
    $strSql = <<<SQL
insert into yoyaku_sold (
registration_id,
price,
time_required,
name
    )
    select r.registration_id, c.price, c.time_required, c.name
    from
    yoyaku_menu_course as c,
    yoyaku_reserved as r
where r.registration_id in ( 
    SELECT id from yoyaku_registration as r
    where (now()) > r.start_time
    )
 and c.id = r.course_id
SQL;

	$wpdb->query($strSql);

    }

    public static function delete_old_data()
    {
	global $wpdb;
    $strSql = <<<SQL
delete from yoyaku_reserved
where registration_id in ( 
    SELECT id from yoyaku_registration as r
    where (now()) > r.start_time
)
SQL;

	$wpdb->query($strSql);
        
    }
}

?>