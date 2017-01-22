<?php
namespace ui;
require_once('/customer/controller.php');
function YoyakuManageConroll()
{
	$templateName = get_query_var( 'pagename' );
	$act = get_query_var( 'target' );

	switch ( $act ) {
		case 'customer':
			$context = new customer\ControlContext();
			$context->Page = get_query_var( 'mode' );;
			$context->RegistMode = get_query_var( 'edit' );
			$context->Id = get_query_var( 'id' );
			$context->TemplatePageName = $templateName;
			$context->SearchResult = get_query_var( 'result' );
			//print_r($context);
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