<?php
namespace ui\send_message\sub_category;
require_once('view-message-detail.php');
use business\entity\SendMessage;

class ViewMessageDetailNew extends ViewMessageDetail
{
	protected function inner_save(SendMessage $msg)
	{
		\business\facade\insert_message_setting($msg);
	}

	protected function add_button()
	{
	}
}
?>