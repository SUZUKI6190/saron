<?php
namespace ui;
require_once("i-controller.php");
require_once("customer/customer-download.php");
require_once("i-edit.php");
require_once(dirname(__FILE__).'/frame/manage-frame-context.php');
require_once(dirname(__FILE__).'/frame/manage-frame.php');
require_once(dirname(__FILE__).'/frame/result.php');
require_once('manage-frame-implementer-factory.php');
require_once(dirname(__FILE__)."/util/control-util.php");
require_once(dirname(__FILE__)."/util/customer-reservation-route.php");
use \ui\frame;

class ManageController implements IController
{
	public function init()
	{
	}
	
	public function view()
	{
		$this->view_manage_gamen();
		exit;
	}


	public function view_manage_gamen()
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
			$set_array("send_message", "メッセージ配信管理", "view");
			$set_array("schedule", "予約管理" , "day_of_the_week");
			$set_array("staff", "スタッフ管理", "view");
			$set_array("sales", "売り上げ管理", "price");

			return $ret;
		}

		$mc = \ui\frame\ManageFrameContext::get_instance();
		$mc->main_category_list = create_main_category();
		$mc->template_page_name = get_query_var( 'pagename' );
		$mc->selected_main_category_name = get_query_var("category");
		$mc->selected_sub_category_name = get_query_var("sub_category");
		
		$inplementer = create_iplementer($mc->selected_main_category_name);
		$css_url = plugins_url("../css" , __FILE__);
		$js_url = plugins_url("../js" , __FILE__);
		
		$cssvar = '0.14';
		$frame = new \ui\frame\ManageFrame($mc->main_category_list, $inplementer);
		$frame->pre_view();
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
		<head>
		<title>予約システム管理画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
		<script type="text/javascript" charset="utf-8" src="<?php echo plugins_url("../js/ui-util.js", __FILE__)?>?ver=0.04" ></script>
		<link rel="stylesheet" href="<?php echo $css_url."/manage_common.css?ver=$cssvar"; ?>"  type="text/css" />
		<link rel="stylesheet" href="<?php echo $css_url."/manage_header.css?ver=$cssvar"; ?>"  type="text/css" />
		<link rel="stylesheet" href="<?php echo $css_url."/customer_search.css?ver=$cssvar"; ?>"  type="text/css" />
		<link rel="stylesheet" href="<?php echo $css_url."/customer_view.css?ver=$cssvar"; ?>"  type="text/css" />
		<?php $inplementer->output_header($css_url, $js_url, $cssvar); ?>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="msapplication-config" content="none"/>
		</head>
		<body>
		<div class="main_wrap">
	<?php

		
		$frame->view();

		?>
		</div>
		<iframe style="height:0px;width:0px;visibility:hidden" src="about:blank">
			this frame prevents back forward cache
		</iframe>
		<body>
		<?php
	}	

}

?>