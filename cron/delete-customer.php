<?php
namespace cron;

function run_delete_customer()
{
    \business\facade\delete_customer_by_last_visit_date();
}

?>
