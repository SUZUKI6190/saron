<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once(dirname(__FILE__)."/../../staff.php");
use ui\frame\ManageFrameContext;
use ui\util\view_date_input;
use ui\util\InputBase;
use ui\util\InputTextarea;
use ui\ViewStaff;

const setting_input_div_name = "setting_input";

class DayCriteriaForm
{
	private $_name;
	private $_from;
	private $_day_count;
	private $_from_value;
	public function __construct($name, $from_value, $day_value)
	{
		$this->_name = $name;
		$this->_from_value = $from_value;
		$this->_from = new view_date_input($name."_from");
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
	
	public function get_from_day() : string
	{
		return $this->_from->get_value();
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
	public function __construct()
	{
		$this->_title =  new InputBase("email", "confirm_mail", "");
		$this->_birth= new DayCriteriaForm("birth", "", "");
		$this->_last_visit = new DayCriteriaForm("last_visi", "", "");
		$this->_next_visit = new DayCriteriaForm("next_visit", "", "");
		$this->_sending_mail = new InputBase("email", "sending_mail", "");
		$this->_confirm_mail = new InputBase("email", "confirm_mail", "");
		$this->_message = new InputTextarea("msg", "");
		$this->_occupation = new InputBase("text", "occupation", "");
		$this->_vist_num = new InputBase("number", "visit_num", "");
		$this->_reservation_route = new InputBase("text", "reservation_route", "");
		$this->_staff = new ViewStaff("staff");
	
	}
	
	protected abstract function inner_save();
	
	public function view()
	{
?>
		<form id="form" name="setting">
		<div class="input_form message_setting">
			<div class="area">
				<div class="line">
					<div class="name">
					メールタイトル
					</div>
					<?php $this->_title->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					誕生日の
					</div>
					<?php $this->_birth->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					最終来店日の
					</div>
					<?php $this->_last_visit->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					次回来店予定日の
					</div>
					<?php $this->_next_visit->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					DM不可を除く
					</div>
					<div class="">
						<input type='checkbox' name='enable_dm' value='enable_dm'>
					</div>
				</div>
				<div class="line">
					<div class="name">
					送信元のメールアドレス
					</div>
					<div class="">
						<?php $this->_sending_mail->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					送信後の確認メールアドレス
					</div>
					<div class="">
						<?php $this->_confirm_mail->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					メッセージ内容
					</div>
					<div class="">
						<?php $this->_message->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					性別
					</div>
					<div class=""：>
		
					<select name="sex" id="sex">
						<option value='None'></option>
						<option value='M'>男性</option>
						<option value='F'>女性</option>
					</select>
			
					</div>
				</div>
				
				<div class="line">
					<div class="name">
					職業
					</div>
					<div class="">
						<?php $this->_occupation->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					来店回数
					</div>
					<div class="">
						<?php $this->_vist_num->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					予約経路
					</div>
					<div class="">
						<?php $this->_reservation_route->view(); ?>
					</div>
				</div>
				<div class="line">
					<div class="name">
					担当スタッフ
					</div>
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