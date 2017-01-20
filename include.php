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
			phone_number varbinary(30),
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

//プラグイン有効化時にテーブルを作成
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
	add_rewrite_rule( '^manage/customer/view', 'index.php?mode=view&action=customer', 'top');
	add_rewrite_rule( '^manage/customer/detail/new', 'index.php?mode=detail&action=customer&edit=new', 'top' );
	add_rewrite_rule( '^manage/customer/detail/edit/([^/]+)/?', 'index.php?mode=detail&action=customer&edit=edit&id=$matches[1]', 'top' );
	flush_rewrite_rules();
}
/*
* $actionパラメータを受け取る準備
*/
function inno_add_query_vars( $vars ) {
	$vars[] = 'edit';
	$vars[] = 'action';
	$vars[] = 'mode';
	$vars[] = 'id';
	return $vars;
}

/*
* パラメータによりファイルを切り替える
*/
function inno_front_controller() {
	$mode = get_query_var( 'mode' );
	$act = get_query_var( 'action' );
	$edit = get_query_var( 'edit' );
	$id = get_query_var( 'id' );
    switch ( $act ) {
        case 'customer':
			require_once(dirname(__FILE__).'/business/facade/customer.php');
			require_once(dirname(__FILE__).'/business/entity/customer.php');		
			require_once(dirname(__FILE__) . '/ui/customer/controller.php');
			$context = new ui\customer\ControlContext();
			$context->Page = $mode;
			$context->RegistMode = $edit;
			$context->Id = $id;
			ui\customer\CustomerController($context);
			exit;
			break;
		case 'login':
			include dirname(__FILE__) . '/templates/login.php';
			exit;
			break;
	}
}

add_action('wp_enqueue_scripts', regist_css);
function regist_css()
{
	wp_register_style(
		'customer_view.css', 
		 plugins_url("/css/customer_view.css", __FILE__)
		 
	);
	
	wp_enqueue_style('customer_view.css');
}

add_shortcode('CreaterCustomerTable', 'ui\customer\CreateCustomerPage');
?>