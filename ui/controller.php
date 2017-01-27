<?php
namespace ui;
require_once('/customer/controller.php');
require_once('/frame/manage-frame-context.php');
require_once('yoyaku-manage-frame.php');
use \ui\frame;
function create_main_category()
{
	
	return [
		new \ui\frame\MainCategory("customer", "お客様管理"),
		new \ui\frame\MainCategory("yoyaku", "予約管理")
	];
}

function YoyakuManageConroll()
{
	$frame = new YoyakuManageFrame([]);
	$mc = \ui\frame\ManageFrameContext::get_instance();
	$mc->main_category_list = create_main_category();
	$mc->template_page_name = get_query_var( 'pagename' );
	$frame->view();

}

?>