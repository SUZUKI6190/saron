<?php
namespace ui;
//require_once('/customer/controller.php');
function YoyakuManageConroll()
{
	$templateName = get_query_var( 'pagename' );
	$mode = get_query_var( 'mode' );
	$act = get_query_var( 'action' );
	$edit = get_query_var( 'edit' );
	$id = get_query_var( 'id' );
	switch ( $act ) {
		case 'customer':
			$context = new customer\ControlContext();
			$context->Page = $mode;
			$context->RegistMode = $edit;
			$context->Id = $id;
			$context->TemplatePageName = $templateName;
			customer\CustomerController($context);
			exit;
			break;
		case 'login':
			include dirname(__FILE__) . '/templates/login.php';
			exit;
			break;
	}
}

?>