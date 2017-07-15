<?php
namespace business\facade;
use \business\entity\SalesMail;

class SalesMailFacade
{
    private function __construct()
    {

    }

    public static function get_all()
    {
        $strSql = <<<SQL
            select
                *
            from
                yoyaku_sales_mail
SQL;

        global $wpdb;
        $result = $wpdb->get_results($strSql);
        $ret = array_values(array_map(function($data) {
            return SalesMailFacade::CreateFromWpdb($data);
        }, $result));

        return $ret;
    }

    public static function delete_by_id($id)
    {
        $strSql = <<<SQL
            delete from yoyaku_sales_mail
            where id = '$id'
SQL;
        global $wpdb;
        $wpdb->query($strSql);
    }

}
?>