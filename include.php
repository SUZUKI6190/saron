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
	add_rewrite_rule( '([^/]+)/customer?$', 'index.php?pagenamecustomer&category=$matches[1]', 'top');
	add_rewrite_rule( '([^/]+)/customer/([^/]+)?$', 'index.php?pagename=$matches[1]&category=customer&sub_category=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/customer/([^/]+)/result?$', 'index.php?pagename=$matches[1]&result=result&category=customer&sub_category=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/customer/([^/]+)/new?$', 'index.php?pagename=$matches[1]&category=customer&sub_category=$matches[2]&edit=new', 'top' );
	add_rewrite_rule( '([^/]+)/customer/([^/]+)/([^/]+)/([0-9]+$)?$', 'index.php?pagename=$matches[1]&category=customer&sub_category=$matches[2]&id=$matches[4]&edit=$matches[3]', 'top' );
	add_rewrite_rule( '([^/]+)/publish/([^/]+)?$', 'index.php?pagename=$matches[1]&category=publish&sub_category=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/publish/menu_regist/([0-9]+$)?$', 'index.php?pagename=$matches[1]&category=publish&sub_category=menu_regist&id=$matches[2]', 'top' );
	add_rewrite_rule( '([^/]+)/publish/menu_regist/course/([0-9]+$)?$', 'index.php?pagename=$matches[1]&category=publish&sub_category=menu_regist&edit=course&id=$matches[2]', 'top' );
	add_rewrite_rule( '([^/]+)/publish/menu_regist/course/([0-9]+)/([0-9]+)?$', 'index.php?pagename=$matches[1]&category=publish&sub_category=menu_regist&edit=course&id=$matches[2]&course_id=$matches[3]', 'top' );
	add_rewrite_rule( '([^/]+)/menu/?$', 'index.php?pagename=$matches[1]&category=menu&menu_id=$matches[2]', 'top' );
	add_rewrite_rule( '([^/]+)/send_message/([^/]+)?$', 'index.php?pagename=$matches[1]&category=send_message&sub_category=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/send_message/edit/([0-9]+$)?$', 'index.php?pagename=$matches[1]&category=send_message&sub_category=edit&id=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/staff/([^/]+)?$', 'index.php?pagename=$matches[1]&category=staff&sub_category=$matches[2]', 'top');
	add_rewrite_rule( '([^/]+)/staff/edit/([0-9]+$)?$', 'index.php?pagename=$matches[1]&category=staff&sub_category=edit&id=$matches[2]', 'top' );
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
	$vars[] = 'menu_id';
	$vars[] = 'course_id';
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

add_action('wp_enqueue_scripts', 'regist_css');

require_once(dirname(__FILE__).'/ui/controller.php');

//プラグイン側から特定のURLでアクセスできるように設定を追加
add_action( 'template_redirect', 'ui\YoyakuManageConroll' );

//add_shortcode('CreaterCustomerTable', 'ui\YoyakuManageConroll');
?>