<?php
namespace cron;
use \business\facade\ScheduledMessageFacade;

function run_scheduled_message()
{
    $msg_list = ScheduledMessageFacade::get_message_list();

    foreach($msg_list as $msg)
    {
        wp_mail($msg->email, $msg->title, $msg->text);
    }
}

?>
