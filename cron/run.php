<?php
namespace cron;
$src_dir = dirname(__FILE__)."/../business";
require_once($src_dir."/entity/config.php");
require_once($src_dir."/entity/scheduled-message.php");
require_once($src_dir."/facade/scheduled-message.php");
require_once($src_dir."/entity/customer.php");
require_once($src_dir."/facade/customer.php");
require_once($src_dir."/entity/sales-mail.php");
require_once($src_dir."/facade/sales-mail.php");
require_once($src_dir."/facade/regist-sold.php");
require_once(dirname(__FILE__)."/scheduled-message.php");
require_once(dirname(__FILE__)."/delete-customer.php");
require_once(dirname(__FILE__)."/send-sales-mail.php");
require_once(dirname(__FILE__)."/regist-sold.php");
require_once(dirname(__FILE__).'/../../../../wp-load.php');
//require_once(dirname(__FILE__).'/../../../../wp-mail.php');

function send_mail($email, $title, $text, $headers)
{
    mb_send_mail($email, $title, $text, $headers);
    //wp_mail($email, $title, $text , $headers);  
}

run_scheduled_message();
run_delete_customer();
run_send_sales_mail();
regist_sold();

?>