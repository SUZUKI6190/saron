<?php
namespace cron;
require_once(dirname(__FILE__)."/../business/facade/scheduled-message.php");
require_once(dirname(__FILE__)."/../business/facade/customer.php");
require_once(dirname(__FILE__)."/../business/facade/sales-mail.php");
require_once("scheduled-message.php");
require_once("delete-customer.php");
require_once("send-sales-mail.php");
require_once(dirname(__FILE__).'/../../../../wp-load.php');
//require_once(dirname(__FILE__).'/../../../../wp-mail.php');

function send_mail($email, $title, $text)
{
    wp_mail($email, $title, $text);    
}

run_scheduled_message();
run_delete_customer();
run_send_sales_mail();

?>