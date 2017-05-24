<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once('view-message-detail-new.php');
require_once('view-message-detail-edit.php');
use ui\frame\ManageFrameContext;
use ui\send_message\SendMessageContext;
use \ui\frame\Result;
use business\entity\SendMessage;

class SettingSub extends \ui\frame\SubCategory
{
	private $_view_detail;
	public function init()
	{
		$context = SendMessageContext::get_instance();
		if(empty($context->message_id)){
			if(!isset($_POST[ViewMessageDetail::PageFlgKey])){
				$empty = SendMessage::get_empty_object();
				$empty->sex = "None";
				$empty->enable_dm = "0";
				$context->set_session($empty);
			}
			$this->_view_detail = new ViewMessageDetailNew();
		}else{
			$this->_view_detail = new ViewMessageDetailEdit();
		}
		
	}

	public function view()
	{
		$this->_view_detail->view();
	}

	public function get_result() : Result
	{
		$ret =  new Result();
		if($this->_view_detail->is_save())
		{
			$ret->message = "メッセージ配信の変更を保存しました。";
			$ret->set_regist_state(true);
		}
		return $ret;
	}

	public function regist()
	{
		$this->_view_detail->save();
	}

	public function get_name()
	{
		return "edit";
	}
	
	public function get_title_name()
	{
		return "メッセージ配信設定を追加";
	}

}

?>