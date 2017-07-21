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
require_once('plugin-menu/create-menu.php');

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
	$h = PluginController::get_head_url_name();
	add_rewrite_rule( $h.'/customer/([^/]+)?$', 'index.php?category=customer&sub_category=$matches[1]', 'top');
	add_rewrite_rule( $h.'/customer/([^/]+)/result?$', 'index.php?result=result&category=customer&sub_category=$matches[2]', 'top');
	add_rewrite_rule( $h.'/customer/([^/]+)/new?$', 'index.php?category=customer&sub_category=$matches[1]&edit=new', 'top' );
	add_rewrite_rule( $h.'/customer/([^/]+)/([^/]+)/([0-9]+$)?$', 'index.php?category=customer&sub_category=$matches[1]&id=$matches[3]&edit=$matches[2]', 'top' );
	add_rewrite_rule( $h.'/publish/([^/]+)?$', 'index.php?category=publish&sub_category=$matches[1]', 'top');
	add_rewrite_rule( $h.'/publish/menu_regist/([0-9]+$)?$', 'index.php?category=publish&sub_category=menu_regist&id=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/publish/menu_regist/course/([0-9]+$)?$', 'index.php?category=publish&sub_category=menu_regist&edit=course&id=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/publish/menu_regist/course/([0-9]+)/([0-9]+)?$', 'index.php?category=publish&sub_category=menu_regist&edit=course&id=$matches[1]&course_id=$matches[2]', 'top' );
	add_rewrite_rule( $h.'/yoyaku/([^/]+)?$', 'index.php?category=yoyaku&sub_category=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/yoyaku/([^/]+)/([0-9]+$)?$', 'index.php?category=yoyaku&sub_category=$matches[1]&id=$matches[2]', 'top' );
	add_rewrite_rule( $h.'/send_message/([^/]+)?$', 'index.php?category=send_message&sub_category=$matches[1]', 'top');
	add_rewrite_rule( $h.'/send_message/edit/([0-9]+$)?$', 'index.php?category=send_message&sub_category=edit&id=$matches[1]', 'top');
	add_rewrite_rule( $h.'/staff/([^/]+)?$', 'index.php?category=staff&sub_category=$matches[1]', 'top');
	add_rewrite_rule( $h.'/staff/edit/([0-9]+$)?$', 'index.php?category=staff&sub_category=edit&id=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/sales/([^/]+)?$', 'index.php?category=sales&sub_category=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/sales/([^/]+)/([^/]+)?$', 'index.php?category=sales&sub_category=$matches[1]&edit=$matches[2]', 'top' );
	add_rewrite_rule( $h.'/image/([^/]+)/([^/]+)?$', 'index.php?category=image&id=$matches[1]&sub_id=$matches[2]', 'top');
	add_rewrite_rule( $h.'/schedule/([^/]+)?$', 'index.php?category=schedule&sub_category=$matches[1]', 'top' );
	add_rewrite_rule( $h.'/?$', 'index.php', 'top');
	add_rewrite_rule( $h.'/download/?$', 'index.php?category=download', 'top');
	flush_rewrite_rules();
}

PluginController::run();

/*
* $actionパラメータを受け取る準備
*/
function inno_add_query_vars( $vars ) {
	$vars[] = 'edit';
	$vars[] = 'category';
	$vars[] = 'sub_category';
	$vars[] = 'id';
	$vars[] = 'sub_id';
	$vars[] = 'result';
	$vars[] = 'menu_id';
	$vars[] = 'course_id';
	return $vars;
}

require_once(dirname(__FILE__).'/ui/controller.php');

//プラグイン側から特定のURLでアクセスできるように設定を追加
add_action( 'template_redirect', 'ui\YoyakuManageConroll' );

add_shortcode('view_menu', 'ui\YoyakuManageConroll');

?>