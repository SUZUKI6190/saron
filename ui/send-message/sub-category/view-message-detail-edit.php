<?php
namespace ui\send_message\sub_category;
require_once('view-message-detail.php');
use business\entity\SendMessage;

class ViewMessageDetailEdit extends ViewMessageDetail
{
	private $_delete_button;
	
	protected function inner_save(SendMessage $msg)
	{
		$context = SendMessageContext::get_instance();
		\business\entity\SendMessage\delete_message_setting($context->message_id);
		\business\entity\SendMessage\insert_message_setting($msg);
	}
	
	public function __construct()
	{
		parent::__construct();
		$this->_delete_button = new ConfirmSubmitButton("delete_button", "削除する", $this->_form_id, "削除します。よろしいですか？");
	}

	protected function add_button()
	{
		$this->_delete_button->view();
	}
	
	public function is_save() : bool
	{
		if(parent::is_save())
		{
			return true;
		}
		
		if($this->_delete_button->is_submit())
		{
			return true;
		}
		
		return false;
	}

	protected function create_default_msg() : SendMessage
	{
		$context = SendMessageContext::get_instance();
		return \business\entity\SendMessage\get_message_setting_byid($context->message_id);
	}
}
?>