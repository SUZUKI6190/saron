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
require_once('business/facade/init.php');
function InitTable()
{
	business\facade\init_db();
}

//プラグイン有効化時にテーブルを作成
register_activation_hook (__FILE__, 'InitTable');

//必要な情報の受け渡しが出来るようquery_varsを追加
add_action( 'query_vars', 'inno_add_query_vars' );

//プラグインを有効化した場合にURLルールを追加
register_activation_hook( __FILE__, 'inno_add_rule' );

/*
* rewrite_ruleの追加
*/
function inno_add_rule() {
	add_rewrite_rule( '([^/]+)/customer/view', 'index.php?pagename=$matches[1]&mode=view&action=customer', 'top');
	add_rewrite_rule( '([^/]+)/customer/search', 'index.php?pagename=$matches[1]&mode=search&action=customer', 'top');
	add_rewrite_rule( '([^/]+)/customer/detail/new', 'index.php?pagename=$matches[1]&mode=detail&action=customer&edit=new', 'top' );
	add_rewrite_rule( '([^/]+)/customer/detail/edit/([^/]+)', 'index.php?pagename=$matches[1]&mode=detail&action=customer&edit=edit&id=$matches[2]', 'top' );
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

add_action('wp_enqueue_scripts', regist_css);
function regist_css()
{
	wp_register_style(
		'customer_view.css', 
		plugins_url("/css/customer_view.css", __FILE__),
		array(),
		"1.0"
		 
	);
	
	wp_enqueue_style('customer_view.css');
}
require_once(dirname(__FILE__).'/business/facade/customer.php');
require_once(dirname(__FILE__).'/business/entity/customer.php');		
require_once(dirname(__FILE__) . '/ui/controller.php');
add_shortcode('CreaterCustomerTable', 'ui\YoyakuManageConroll');
?>