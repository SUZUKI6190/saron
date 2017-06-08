<?php
namespace ui\send_message\sub_category;
require_once('view-message-detail.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\ConfirmSubmitButton;

class ViewMessageDetailEdit extends ViewMessageDetail
{
	private $_delete_button;
	
	protected function inner_save(SendMessage $msg)
	{
		$context = SendMessageContext::get_instance();

		if($this->_save_button->is_submit()){
			\business\facade\update_message_setting($msg);
		}

		if($this->_delete_button->is_submit()){
			\business\facade\delete_message_setting($context->message_id);
		}
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

}
?>