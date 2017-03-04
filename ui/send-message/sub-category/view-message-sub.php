<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once('view-message-detail-new.php');
use ui\frame\ManageFrameContext;

class ViewMessageSub extends \ui\frame\SubCategory
{
	private $_msg_list = [];
	private $_form_id = "msg_form";

	public function __construct()
	{
		$this->_msg_list = \business\facade\get_message_setting_all();
	}
	public function view()
	{
		$mc = ManageFrameContext::get_instance();
		$url = $mc->get_url()."/send_message/edit/";
		?>
		<form method="post" id='<?php echo $this->_form_id; ?>' >
		
		<?php
		
	?>
		<div class="setting_width centering">

		<table class="staff_view_table">
		<thead><tr>
		<th>メールタイトル</th>
		<th></th>
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
				<td>
					<?php \ui\util\link_button("編集", $url."/".$msg->id); ?>
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