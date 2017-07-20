<?php
namespace cron;
$src_dir = dirname(__FILE__)."/../business";
require_once($src_dir."/entity/scheduled-message.php");
require_once($src_dir."/facade/scheduled-message.php");
require_once($src_dir."/entity/customer.php");
require_once($src_dir."/facade/customer.php");
require_once($src_dir."/entity/sales-mail.php");
require_once($src_dir."/facade/sales-mail.php");
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