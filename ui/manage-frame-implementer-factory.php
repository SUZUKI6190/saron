<?php
namespace ui;

require_once("frame/manage-frame.php");
require_once("customer/customer-frame-implementer.php");
require_once("publish/publish-frame-implementor.php");
require_once("publish/publish-context.php");
use ui\publish\PublishContext;

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
		case "publish":
			$context = PublishContext::get_instance();
			$context->course_id = get_query_var( 'id' );
			$context->menu_id = get_query_var( 'id' );
			$context->edit_mode = get_query_var( 'edit' );
			print_r($context);
			return new  publish\PublishFrameImplementor();
			break;
		default:
			echo "invalid url error";
			break;
	}
}

?>