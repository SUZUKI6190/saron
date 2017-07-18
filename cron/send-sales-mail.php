<?php
namespace cron;
use \business\facade\SalesMailFacade;

function run_send_sales_mail()
{
    $mail_list = SalesMailFacade:get_all();
    foreach($mail_list as $m)
    {
        wp_mail($m->email, $m->get_title(), $m->get_text());
    }
}

?>