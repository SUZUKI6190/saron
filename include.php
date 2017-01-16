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
	dbDelta(<<<SQL
		CREATE TABLE Customer (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			tanto_id bigint(20) UNSIGNED,
			name_kanji_last varbinary(100),
			name_kanji_first varbinary(100),
			name_kana_last varbinary(100),
			name_kana_first varbinary(100),
			sex TINYINT UNSIGNED,	
			old TINYINT UNSIGNED,
			birthday varbinary(20),
			last_visit_date varbinary(20),
			phone_number bigint(11),
			address varbinary(500),
			occupation TINYINT UNSIGNED,
			number_of_visit bigint(10),
			email varbinary(200),
			enable_dm TINYINT UNSIGNED,
			next_visit_reservation_date varbinary(200),
			reservation_route varbinary(500),
			remarks varbinary(500),
			PRIMARY KEY(id)
		)
SQL
		);

	dbDelta(<<<SQL
		CREATE TABLE Staff (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(100),
			PRIMARY KEY(id)
		)
SQL
		);	
}

//プラグイン有効かしたとき実行
register_activation_hook (__FILE__, 'InitTable');

//必要な情報の受け渡しが出来るようquery_varsを追加
add_action( 'query_vars', 'inno_add_query_vars' );

//プラグイン側から固定ページを作成したので、特定のURLでアクセスできるように設定を追加
add_action( 'template_redirect', 'inno_front_controller' );

//プラグインを有効化した場合にURLルールを追加
register_activation_hook( __FILE__, 'inno_add_rule' );

/*
* rewrite_ruleの追加
*/
function inno_add_rule() {
	add_rewrite_rule( '^manage/([^/]+)/?', 'index.php?action=$matches[1]', 'top' );
	flush_rewrite_rules();
}
/*
* $actionパラメータを受け取る準備
*/
function inno_add_query_vars( $vars ) {
	$vars[] = 'action';
	return $vars;
}

/*
* パラメータによりファイルを切り替える
*/
function inno_front_controller() {
	$rule = get_query_var( 'action' );
    switch ( $rule ) {
        case 'customer':
			include dirname(__FILE__) . '/ui/customer/controller.php';
			exit;
			break;

		case 'login':
			include dirname(__FILE__) . '/templates/login.php';
			exit;
			break;
	}
}


add_shortcode('CreaterCustomerTable', 'ui\customer\CreateCustomerPage');
?>