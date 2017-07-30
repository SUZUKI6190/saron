<?php
namespace business\facade;
use \business\entity\SalesMail;
use \business\entity\Config;

class SalesMailFacade
{
    private function __construct(){}

    public static function get_last_month() : SalesMail
    {
        $title_id = Config::SalesMailTitleId;
        $msg_id = Config::SalesMailMessageId;
        $user_id = Config::SalesMailUserNameId;
        $user_address_id = Config::SalesMailUserAddressNameId;

        $strSql = <<<SQL
        select
            (select value from yoyaku_config where id = '$title_id') as title,
            (select value from yoyaku_config where id = '$msg_id') as msg,
            (select value from yoyaku_config where id = '$user_id') as send_user_name,
            (select value from yoyaku_config where id = '$user_address_id') as send_user_address,
            sum(rc.price) as price_sum,
            count(*) as sales_num,
            sum(rc.price) / (select count(*) from yoyaku_registration as yr
                    WHERE yr.start_time >= DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -2 MONTH)
                    AND yr.start_time <  DATE_ADD(DATE_ADD(LAST_DAY(NOW()), INTERVAL 1 DAY), INTERVAL -1 MONTH)
                ) as per_customer
            FROM  yoyaku_sold as rc
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