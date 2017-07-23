<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once('view-message-detail-new.php');
use ui\frame\ManageFrameContext;
use ui\send_message\SendMessageContext;

class ViewMessageSub extends \ui\frame\SubCategory
{
	private $_msg_list = [];
	private $_form_id = "msg_form";
	const EditKey = "edit";
	public function init()
	{
		$this->_msg_list = \business\facade\get_message_setting_all();
	}

	public function pre_view()
	{
		if(isset($_POST[self::EditKey]))
		{
			$msg_id = $_POST[self::EditKey];
			$send_message = \business\facade\get_message_setting_byid($msg_id);

			$sc = SendMessageContext::get_instance();
			$sc->set_session($send_message);
			$mc = ManageFrameContext::get_instance();
			$d = "?d=".(new \DateTime())->format("Ymdhis");
			$url = $mc->get_url()."/send_message/edit/$msg_id".$d;
			header("Location:$url");
			exit;
		}
	}

	public function view()
	{
		$mc = ManageFrameContext::get_instance();
		$url = $mc->get_url()."/send_message/edit/";
		$edit_key = self::EditKey;
		?>
		<form method="post" id='<?php echo $this->_form_id; ?>' >

		<div class="setting_width centering">

		<table class="staff_view_table">
		<thead><tr>
		<th class='mail_title_head'>メールタイトル</th>
		<th class='cmd_head'></th>
		</thead>

		<?php
		foreach($this->_msg_list as $msg)
		{
			?>
			<tr>
				<td class="menu_name">
					<?php
					echo $msg->title;
					?>
				</td>
				<td class='cmd_td'>
					<?php echo "<button class='manage_button' type='submit' name='$edit_key' value='$msg->id'>編集</button>"; ?>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		
		<?php
		
		?>
		</div>
		</form>
		<?php
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