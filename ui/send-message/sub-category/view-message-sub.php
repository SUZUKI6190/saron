<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once('view-message-detail-new.php');
use ui\frame\ManageFrameContext;

class ViewMessageSub extends \ui\frame\SubCategory
{
	private $_view_detail;
	public function __construct()
	{
		$this->_view_detail = new ViewMessageDetailNew();
	}
	public function view()
	{
		$this->_view_detail->view();
	}

	public function get_name()
	{
		return "view";
	}
	
	public function get_title_name()
	{
		return "配信メッセージ一覧";
	}

}

?>