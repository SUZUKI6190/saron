<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once(dirname(__FILE__)."/../../staff.php");
require_once(dirname(__FILE__).'/../../../business/entity/send-message.php');
require_once(dirname(__FILE__).'/../../../business/facade/send-message.php');
use ui\frame\ManageFrameContext;
use ui\util\view_date_input;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
const setting_input_div_name = "setting_input";

class DayCriteriaForm
{
	private $_name;
	private $_from;
	private $_day_count;
	public function __construct($name, $day_value)
	{
		$this->_name = $name;
		$this->_day_count = new InputBase("number", $name."_days", $day_value);
	}
	
	public function view()
	{?>
		<div class='<?php echo setting_input_div_name ?>'>
			<?php $this->_day_count->view(); ?>
			日前に自動配信
		</div>
<?php }

	public function get_day_num() : string
	{
		return $this->_day_count->get_value();
	}
	
}

abstract class ViewMessageDetail
{
	private $_title, $_birth, $_lase_visit, $_next_visit;
	private $_sending_mail, $_confirm_mail;
	private $_message;
	private $_occupation;
	private $_vist_num;
	private $_reservation_route;
	private $_staff;
	private $_default_msg;
	protected $_save_button;
	protected $_form_id = "msg_setting_input_form";
	public function __construct()
	{
		$required_attr = [];
		$required_attr["required"] = "";
		$this->_save_button = new SubmitButton("save_button", "保存する", $this->_form_id);
		$this->_default_msg = $this->create_default_msg();
		$this->_title =  new InputBase("text", "mail_title", $this->_default_msg->title, "", $required_attr);
		$this->_birth= new DayCriteriaForm("birth", $this->_default_msg->birth);
		$this->_last_visit = new DayCriteriaForm("last_visi", $this->_default_msg->last_visit);
		$this->_next_visit = new DayCriteriaForm("next_visit", $this->_default_msg->next_visit);
		$this->_sending_mail = new InputBase("email", "sending_mail", $this->_default_msg->sending_mail);
		$this->_confirm_mail = new InputBase("email", "confirm_mail", $this->_default_msg->confirm_mail);
		$this->_message = new InputTextarea("msg", $this->_default_msg->message_text);
		$this->_occupation = new InputBase("text", "occupation", $this->_default_msg->occupation);
		$this->_vist_num = new InputBase("number", "visit_num", $this->_default_msg->visit_num);
		$this->_reservation_route = new RouteSelect();
		$this->_reservation_route->set_name("reservation_route");
		$this->_reservation_route->set_selected_id($this->_default_msg->reservation_route);
		$this->_staff = new ViewStaff("staff");
	}
	
	public function save()
	{
		$msg = new SendMessage();
		$msg->id = SendMessageContext::get_instance()->message_id;
		$msg->title = $this->_title->get_value();
		$msg->birth = $this->_birth->get_day_num();
		$msg->last_visit = $this->_last_visit->get_day_num();
		$msg->next_visit =$this->_next_visit->get_day_num();
		$msg->sending_mail = $this->_sending_mail->get_value();
		$msg->confirm_mail = $this->_confirm_mail->get_value();
		$msg->message_text = $this->_message->get_value();
		$msg->occupation = $this->_occupation->get_value();
		$msg->visit_num = $this->_vist_num->get_value();
		$msg->reservation_route = $this->_reservation_route->get_value();
		$this->inner_save($msg);
	}

	protected abstract function inner_save(SendMessage $msg);
	
	protected abstract function create_default_msg() : SendMessage;
	
	protected abstract function add_button();

	public function is_save() : bool
	{
		return $this->_save_button->is_submit();
	}
	
	public function view()
	{
?>
		<form id='<?php echo $this->_form_id; ?>' name="setting" method="post">
		<div class="input_form message_setting">
			<div class="msg_form_button">
				<?php
				$this->_save_button->view();
				$this->add_button();
				?>
			</div>
			<div class="area">
				<div class="line">
					<h2>
					メールタイトル
					</h2>
					<?php $this->_title->view(); ?>
				</div>
				<div class="line">
					<h2>
					誕生日の
					</h2>
					<?php $this->_birth->view(); ?>
				</div>
				<div class="line">
					<h2>
					最終来店日の
					</h2>
					<?php $this->_last_visit->view(); ?>
				</div>
				<div class="line">
					<h2>
					次回来店予定日の
					</h2>
					<?php $this->_next_visit->view(); ?>
				</div>
				<div class="line">
					<h2>
					DM不可を除く
					</h2>
					<div class="">
						<input type='checkbox' name='enable_dm' value='enable_dm'>
					</div>
				</div>
				<div class="line">
					<h2>
					送信元のメールアドレス
					</h2>
					<div class="">
						<?php $this->_sending_mail->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					送信後の確認メールアドレス
					</h2>
					<div class="">
						<?php $this->_confirm_mail->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					メッセージ内容
					</h2>
					<div class="">
						<?php $this->_message->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					性別
					</h2>
					<div class=""：>
		
					<select name="sex" id="sex">
						<option value='None'></option>
						<option value='M'>男性</option>
						<option value='F'>女性</option>
					</select>
			
					</div>
				</div>
				
				<div class="line">
					<h2>
					職業
					</h2>
					<div class="">
						<?php $this->_occupation->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					来店回数
					</h2>
					<div class="">
						<?php $this->_vist_num->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					予約経路
					</h2>
					<div class="">
						<?php $this->_reservation_route->view(); ?>
					</div>
				</div>
				<div class="line">
					<h2>
					担当スタッフ
					</h2>
					<div class="">
						<?php $this->_staff->view_staff_select(); ?>
					</div>
				</div>				
			<div>
		</div>
		</form>
		<?php
	}	
}

?>