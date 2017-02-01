<?php
namespace ui;

require_once("frame/manage-frame.php");
require_once("customer/customer-frame-implementer.php");

function create_iplementer($category_name)
{
	switch($category_name)
	{
		case "customer":
			$context = new customer\ControlContext();
			$context->Page = get_query_var( 'sub_category' );;
			$context->RegistMode = get_query_var( 'edit' );
			$context->Id = get_query_var( 'id' );
			$context->TemplatePageName = get_query_var( 'pagename' );;
			$context->SearchResult = get_query_var( 'result' );
			return new  customer\CustomerFameImplementor($context);
			break;
		default:
			break;
	}
}

?>