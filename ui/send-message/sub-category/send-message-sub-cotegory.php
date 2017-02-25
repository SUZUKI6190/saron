<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
use ui\frame\ManageFrameContext;
use ui\util\view_date_input;
use ui\util\InputBase;
use ui\util\InputTextarea;

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
			<?php $this->_from->view($this->_from_value); ?>
			<br>の<br>
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

class SettingSub extends \ui\frame\SubCategory
{
	
	private $_birth, $_lase_visit, $_next_visit;
	private $_sending_mail, $_confirm_mail;
	private $_message;
	public function __construct()
	{
		$this->_birth= new DayCriteriaForm("birth", "", "");
		$this->_last_visit = new DayCriteriaForm("last_visi", "", "");
		$this->_next_visit = new DayCriteriaForm("next_visit", "", "");
		$this->_sending_mail = new InputBase("email", "sending_mail", "");
		$this->_confirm_mail = new InputBase("email", "confirm_mail", "");
		$this->_message = new InputTextarea("msg", "");
	}
	public function view()
	{
		?>
		<form id="form" name="setting">
		<div class="input_form message_setting">
			<div class="area">
				<div class="line">
					<div class="name">
					誕生日
					</div>
					<?php $this->_birth->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					最終来店日
					</div>
					<?php $this->_last_visit->view(); ?>
				</div>
				<div class="line">
					<div class="name">
					次回来店予定日
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
			<div>
		</div>
		</form>
		<?php
	}

	public function get_name()
	{
		return "setting";
	}
	
	public function get_title_name()
	{
		return "メッセージ配信設定";
	}

}

?>