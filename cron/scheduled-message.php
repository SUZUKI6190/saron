<?php
namespace cron;
use \business\facade\ScheduledMessageFacade;

function run_scheduled_message()
{
    $msg_list = ScheduledMessageFacade::get_message_list();

    foreach($msg_list as $msg)
    {
        $headers = "From: test <harp6662002@yahoo.co.jp>" . "\r\n";
        send_mail($msg->email, $msg->title, $msg->text, $headers);
    }
}

?>
