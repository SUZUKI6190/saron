<?php
namespace ui;
require_once('/customer/controller.php');
require_once('/frame/manage-frame-context.php');
require_once('yoyaku-manage-frame.php');

function get_sub_cotegory_list($main_category_name)
{
	switch($main_category_name)
	{
		case 'customer':
			return ['search'];
			break;
		default:
			break;
	}
}

function YoyakuManageConroll()
{
	$frame = new YoyakuManageFrame([]);
	
	$frame->view();
	/*
	$templateName = get_query_var( 'pagename' );
	$act = get_query_var( 'category' );
	
	switch ( $act ) {
		case 'customer':
			$context = new customer\ControlContext();
			$context->Page = get_query_var( 'sub_category' );;
			$context->RegistMode = get_query_var( 'edit' );
			$context->Id = get_query_var( 'id' );
			$context->TemplatePageName = $templateName;
			$context->SearchResult = get_query_var( 'result' );
			customer\CustomerController($context);
			
			exit;
			break;
		case 'login':
			include dirname(__FILE__) . '/templates/login.php';
			exit;
			break;
	}
	*/
}

?>