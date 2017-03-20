<?php
namespace ui;

require_once("frame/manage-frame.php");
require_once("customer/customer-frame-implementer.php");
require_once("customer/controller.php");
require_once("publish/publish-frame-implementor.php");
require_once("publish/publish-context.php");
require_once("staff/staff-context.php");
require_once("send-message/send-message-frame-implementor.php");
require_once("send-message/send-message-context.php");
require_once("staff/staff-implementor.php");
require_once("sales/sales-frame-implementor.php");
use ui\publish\PublishContext;
use ui\staff\StaffContext;
use ui\send_message\SendMessageContext;
use ui\sales\SalesContext;

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
			$context->course_id = get_query_var( 'course_id' );
			$context->menu_id = get_query_var( 'id' );
			$context->is_course_edit = (get_query_var( 'edit' ) == PublishContext::$CourseEditParam);
			return new  publish\PublishFrameImplementor();
			break;
		case "send_message":
			$context = SendMessageContext::get_instance();
			$context->message_id = get_query_var( 'id' );
			return new  send_message\SendMessageImplementor();
			break;
		case "staff":
			$context = StaffContext::get_instance();
			$context->staff_id = get_query_var( 'id' );
			return new staff\StaffFrameImplementor();
			break;	
		case "sales":
			$context = SalesContext::get_instance();
			return new sales\SalesFrameImplementor();
			break;
		default:
			echo "invalid url error : $category_name";
			break;
	}
}

?>