<?php
namespace cron;
require_once("scheduled-message.php");
require_once(dirname(__FILE__)."/../business/entity/customer.php");
require_once(dirname(__FILE__)."/../business/entity/scheduled-message.php");

run_scheduled_message();

?>