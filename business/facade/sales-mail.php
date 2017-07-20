<?php
namespace business\facade;
use \business\entity\SalesMail;

class SalesMailFacade
{
    private function __construct(){}

    public static function get_last_month() : SalesMail
    {
        $strSql = <<<SQL
        select
            (select value from yoyaku_config where id = '5') as title,
            (select value from yoyaku_config where id = '6') as msg,
            sum(rc.price) as sum_pride,
            count(*) as sales_num,
            sum(rc.price) / (select count(*) from yoyaku_registration as yr
                    WHERE yr.start_time >= DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -2 MONTH)
                    AND yr.start_time <  DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -1 MONTH)
                ) as per_customer
            FROM  yoyaku_reserved_course as rc
            where id in (select id from yoyaku_registration as yr
                    WHERE yr.start_time >= DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -2 MONTH)
                    AND yr.start_time <  DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -1 MONTH)
                )
SQL;

        global $wpdb;
        $result = $wpdb->get_results($strSql);
        return SalesMail::CreateFromWpdb($result[0]);
        
    }
}

?>