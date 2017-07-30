<?php
namespace cron;
namespace business\facade\RegistSold;

function regist_sold()
{
    RegistSold::RegistSold();
    RegistSold::delete_old_data();
}

?>