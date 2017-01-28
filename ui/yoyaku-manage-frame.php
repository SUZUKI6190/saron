<?php
namespace ui;

require_once("frame/manage-frame.php");
require_once("frame/manage-frame-context.php");
require_once("frame/manage-frame-context.php");
require_once('customer/customer-subcotegory-factory.php');

function create_main_header($name)
{
	switch($name)
	{
		case("customer"):
			break;
	}
}

class YoyakuManageFrame extends \ui\frame\ManageFrame
{
	public function view_main()
	{
		$templateName = get_query_var( 'pagename' );
		$category= get_query_var( 'category' );
		
		$mc = \ui\frame\ManageFrameContext::get_instance();
		$mc->template_page_name = $templateName;
		switch ( $category ) {
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
	}
	
	public function create_sub_category_list($main_category_name)
	{
		$mc = \ui\frame\ManageFrameContext::get_instance();
		switch ( $main_category_name ) {
			case 'customer':
				$context = new customer\ControlContext();
				$context->Page = get_query_var( 'sub_category' );;
				$context->RegistMode = get_query_var( 'edit' );
				$context->Id = get_query_var( 'id' );
				$context->TemplatePageName = get_query_var( 'pagename' );
				$context->SearchResult = get_query_var( 'result' );
				return \ui\customer\create_customer_sub_category($context);
				break;
			default;
				return [];
				break;
		}
	}
}
?>