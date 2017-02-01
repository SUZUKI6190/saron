<?php
namespace ui;
require_once('customer/controller.php');
require_once(dirname(__FILE__).'/frame/manage-frame-context.php');
require_once(dirname(__FILE__).'/frame/manage-frame.php');
require_once('manage-frame-implementer-factory.php');
use \ui\frame;
function create_main_category()
{
	
	return [
		new \ui\frame\MainCategory("customer", "お客様管理"),
		new \ui\frame\MainCategory("yoyaku", "予約管理"),
		new \ui\frame\MainCategory("send-message", "メッセージ配信管理"),
		new \ui\frame\MainCategory("staff", "スタッフ管理")
	];
}

function YoyakuManageConroll()
{

	$mc = \ui\frame\ManageFrameContext::get_instance();
	$mc->main_category_list = create_main_category();
	$mc->template_page_name = get_query_var( 'pagename' );
	$mc->selected_main_category_name = get_query_var("category");
	$mc->selected_sub_category_name = get_query_var("sub_category");
	
	$inplementer = create_iplementer($mc->selected_main_category_name);
	$frame = new \ui\frame\ManageFrame($mc->main_category_list, $inplementer);
	$frame->view();

}

?>