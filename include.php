<?php
/*
Plugin Name:YoyakuSystem
Plugin URI: 
Description: 
Author: Takashi Suzuki
Version: 1.0
Author URI:
*/
require_once('ui/itabledata.php');
require_once('business/entity/customer.php');
require_once('business/facade/customer.php');
require_once('ui/customerTable.php');
require_once('data/dbinit.php');
add_shortcode('CreaterCustomerTable', 'CreaterCustomerTable');
?>