<?php
namespace cron;
use \business\facade\SalesMailSettingFacade;
use \business\facade\SalesMailFacade;

function run_send_sales_mail()
{
    $date = new \DateTime();
    $day = (int)$date->format('d');
    if($day != 1)
    {
        return;
    }
    $mail = SalesMailFacade::get_last_month();
    $mail_list = SalesMailSettingFacade::get_all();

    foreach($mail_list as $m)
    {
        $headers = "From: $m->send_user_name <$m->sending_mail>" . "\r\n";
        send_mail($m->email, $mail->create_title(), $mail->create_text(), $headers);
    }
}

?>