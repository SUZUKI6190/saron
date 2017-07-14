<?php
namespace cron;
require_once(dirname(__FILE__)."/../business/entity/scheduled-message.php");
require_once(dirname(__FILE__)."/../business/facade/scheduled-message.php");
use \business\facade\ScheduledMessageFacade;

function run_scheduled_message()
{
    $msg_list = ScheduledMessageFacade::get_message_list();

    foreach($msg_list as $msg)
    {
        \wp_mail($msg->email, $msg->title, $msg->text);
    }
}

?>
