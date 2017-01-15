<?php
/*
Plugin Name:YoyakuSystem
Plugin URI: 
Description: 
Author: Takashi Suzuki
Version: 1.0
Author URI:
*/
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

function InitTable()
{
	global $wpdb;
	$strSql = <<<SQL
		CREATE TABLE Customer (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			tanto_id bigint(20) UNSIGNED,
			name_kanji 	varbinary(200),
			name_kana  	varbinary(200),
			sex TINYINT UNSIGNED,	
			old TINYINT UNSIGNED,
			birthday varbinary(20),
			last_visit_date varbinary(20),
			phone_number bigint(11),
			address varbinary(500),
			occupation varbinary(200),
			number_of_visit bigint(10),
			email varbinary(200),
			enable_dm TINYINT UNSIGNED,
			next_visit_reservation_date varbinary(200),
			reservation_route varbinary(500),
			remarks varbinary(500),
			PRIMARY KEY(id)
		)
SQL;
	dbDelta($strSql);	
}

//プラグイン有効かしたとき実行
register_activation_hook (__FILE__, 'InitTable');

require_once('ui/itabledata.php');
require_once('business/entity/customer.php');
require_once('business/facade/customer.php');
require_once('ui/customerTable.php');
add_shortcode('CreaterCustomerTable', 'ui\CreaterCustomerTable');
?>