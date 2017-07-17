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
            return SalesMail::CreateFromWpdb($data);
        }, $result));

        return $ret;
    }

    public static function get_by_id($id)
    {
        $strSql = <<<SQL
            select
                *
            from
                yoyaku_sales_mail
            where id = '$id'
SQL;

        global $wpdb;
        $result = $wpdb->get_results($strSql);
        return SalesMail::CreateFromWpdb($result[0]);
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

    public static function insert(SalesMail $data)
    {
        global $wpdb;
        $wpdb->query(
            <<<SQL
            insert into yoyaku_sales_mail (
                email
            )values(
                '$data->email'
            )
SQL
);
    }

    public static function update(SalesMail $data)
    {
        global $wpdb;
        $wpdb->query(
            <<<SQL
            UPDATE yoyaku_sales_mail SET 
                email = '$data->email'
            where id = '$data->id'
SQL
    );
    }


}
?>