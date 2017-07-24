<?php
namespace cron;
use \business\facade\ScheduledMessageFacade;

function run_scheduled_message()
{
    $msg_list = ScheduledMessageFacade::get_message_list();

    foreach($msg_list as $msg)
    {
        $headers = "From: $msg->send_user_name <$msg->send_user_address>" . "\r\n";
        send_mail($msg->email, $msg->title, $msg->text, $headers);
    }
}

?>
