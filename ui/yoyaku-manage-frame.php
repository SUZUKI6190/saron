<?php
namespace ui;

require_once("frame/manage-frame.php");

class YoyakuManageFrame extends \ui\frame\ManageFrame
{
	public function view_main()
	{
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
	}
}
?>