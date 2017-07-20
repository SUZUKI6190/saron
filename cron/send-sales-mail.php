<?php
namespace cron;
use \business\facade\SalesMailSettingFacade;
use \business\facade\SalesMailFacade;

function run_send_sales_mail()
{
    $mail = SalesMailFacade::get_last_month();
    $mail_list = SalesMailSettingFacade::get_all();

    foreach($mail_list as $m)
    {
        send_mail($m->email, $mail->title(), $mail->create_text());
    }
}

?>