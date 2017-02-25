<?php
namespace ui;
require_once('customer/controller.php');
require_once("customer/customer-download.php");
require_once(dirname(__FILE__).'/frame/manage-frame-context.php');
require_once(dirname(__FILE__).'/frame/manage-frame.php');
require_once(dirname(__FILE__).'/frame/result.php');
require_once('manage-frame-implementer-factory.php');
use \ui\frame;

function view_manage_gamen()
{
	function create_main_category()
	{
		$ret =[];
		$set_array = function ($name, $text, $default_name) use(&$ret)
		{
			$ret[$name] = new \ui\frame\MainCategory($name, $text, $default_name);
		};

		$set_array("customer", "お客様管理", "search");
		$set_array("publish", "掲載管理", "menu");
		$set_array("send_message", "メッセージ配信管理", "setting");
		$set_array("yoyaku", "予約管理" , "menu");
		$set_array("staff", "スタッフ管理", "menu");

		return $ret;
	}

	$mc = \ui\frame\ManageFrameContext::get_instance();
	$mc->main_category_list = create_main_category();
	$mc->template_page_name = get_query_var( 'pagename' );
	$mc->selected_main_category_name = get_query_var("category");
	$mc->selected_sub_category_name = get_query_var("sub_category");
	
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Expires" content="0" /><title></title>
	
	<script type="text/javascript" charset="utf-8" src="<?php echo plugins_url("../js/ui-util.js", __FILE__)?>?ver=0.03" ></script>
	<link rel="stylesheet" href="<?php echo plugins_url("../css/manage_common.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="stylesheet" href="<?php echo plugins_url("../css/manage_header.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="stylesheet" href="<?php echo plugins_url("../css/customer_search.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="stylesheet" href="<?php echo plugins_url("../css/customer_view.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="stylesheet" href="<?php echo plugins_url("../css/publish_menu.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="stylesheet" href="<?php echo plugins_url("../css/send_message.css", __FILE__); ?>?ver=0.04"  type="text/css" />
	<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
	<meta name="format-detection" content="telephone=no"/>
	<meta name="msapplication-config" content="none"/>
	</head>
	<body>
	<div class="main_wrap">
<?php

	$inplementer = create_iplementer($mc->selected_main_category_name);
	
	$frame = new \ui\frame\ManageFrame($mc->main_category_list, $inplementer);
	$frame->view();

	?>
	</div>
	<body>
	<?php
}

function YoyakuManageConroll()
{
	if(get_query_var("category") == "download"){
		\ui\customer\get_customer_csv();
	}else{
		view_manage_gamen();
	}
	exit;
}

?>