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
	add_rewrite_rule( '([^/]+)/([^/]+)/([^/]+)?$', 'index.php?pagename=$matches[1]&category=$matches[2]&sub_category=$matches[3]', 'top');
	add_rewrite_rule( '([^/]+)/([^/]+)/([^/]+)/result?$', 'index.php?pagename=$matches[1]&result=result&category=$matches[2]&sub_category=$matches[3]', 'top');
	add_rewrite_rule( '([^/]+)/([^/]+)/([^/]+)/new?$', 'index.php?pagename=$matches[1]&category=$matches[2]&sub_category=$matches[3]&edit=new', 'top' );
	add_rewrite_rule( '([^/]+)/([^/]+)/([^/]+)/edit/([^/]+)', 'index.php?pagename=$matches[1]&category=$matches[2]&sub_category=$matches[3]&edit=edit&id=$matches[4]', 'top' );
	flush_rewrite_rules();
}
/*
* $actionパラメータを受け取る準備
*/
function inno_add_query_vars( $vars ) {
	$vars[] = 'edit';
	$vars[] = 'category';
	$vars[] = 'sub_category';
	$vars[] = 'id';
	$vars[] = 'result';
	return $vars;
}

function regist_css()
{
	wp_register_style(
		'customer_view.css', 
		plugins_url("/css/customer_view.css", __FILE__),
		array(),
		"1.0"
		 
	);
	
	wp_enqueue_style('customer_view.css');

	wp_register_style(
		'customer_search.css', 
		plugins_url("/css/customer_search.css", __FILE__),
		array(),
		"0.006"
		 
	);
	
	wp_enqueue_style('customer_search.css');
	
	wp_enqueue_style('manage_common.css');

	wp_register_style(
		'manage_common.css', 
		plugins_url("/css/manage_common.css", __FILE__),
		array(),
		"0.002"
	);
	
	wp_enqueue_style('manage_common.css');
	
}

add_action('wp_enqueue_scripts', regist_css);

require_once(dirname(__FILE__).'/business/facade/customer.php');
require_once(dirname(__FILE__).'/business/entity/customer.php');		
require_once(dirname(__FILE__) . '/ui/controller.php');
add_shortcode('CreaterCustomerTable', 'ui\YoyakuManageConroll');
?>