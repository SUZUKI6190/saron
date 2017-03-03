<?php
namespace ui\send_message\sub_category;
require_once('view-message-detail.php');
use business\entity\SendMessage;

class ViewMessageDetailNew extends ViewMessageDetail
{
	protected function inner_save(SendMessage $msg)
	{
	}

	protected function add_button()
	{
	}
	
	protected function create_default_msg() : SendMessage
	{
		return SendMessage::get_empty_object();
	}
}
?>