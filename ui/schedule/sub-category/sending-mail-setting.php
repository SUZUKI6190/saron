<?php
namespace ui\schedule;

use ui\frame\ManageFrameContext;
use \business\entity\Config;

use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\scheule\ScheduleContext;

class SendingMailSettingSub extends \ui\frame\SubCategory
{
	const update_btn_name = 'update_btn';
	const yoyaku_mail_address_name = 'yoyaku_mail';
	const yoyaku_mail_title_name = 'yoyaku_titke';
	const yoyaku_mail_content_name = 'yoyaku_content';

	public function init()
	{
		if($this->is_update_click())
		{
			$c = Config::get_instance();
			$c->YoyakuMailAddress->save_value($this->get_yoyaku_mail_address());
			$c->YoyakuMailTitle->save_value($this->get_yoyaku_mail_title());
			$c->YoyakuMailContent->save_value($this->get_yoyaku_mail_content());
		}
	}

	private function is_update_click() : bool
	{
		return isset($_POST[self::update_btn_name]);
	}

	private function get_yoyaku_mail_address()
	{
		return $_POST[self::yoyaku_mail_address_name];
	}


	private function get_yoyaku_mail_title()
	{
		return $_POST[self::yoyaku_mail_title_name];
	}

	private function get_yoyaku_mail_content()
	{
		return $_POST[self::yoyaku_mail_content_name];
	}

	public function view()
	{
		$c = Config::get_instance();
		$d = "?d=".(new \DateTime())->format("Ymdhis");
		?>
		<form method='post' action='<?php echo "$d" ?>'>
			<div class='main_content centering'>
				<div class='config_input_wrap'>
					<div class='save_btn_area'>
						<button type='submit' class='manage_button' name='<?php echo self::update_btn_name; ?>'>更新する</button>
					</div>
					<div class='setting_area'>
						<h2 class='edit_midasi'>
							予約メール送信先
						</h2>
						<input type='email' name='<?php echo self::yoyaku_mail_address_name; ?>' value='<?php echo $c->YoyakuMailAddress->get_value(); ?>' >
						<h2 class='edit_midasi'>
							予約メール件名
						</h2>
						<input type='text' name='<?php echo self::yoyaku_mail_title_name; ?>' value='<?php echo $c->YoyakuMailTitle->get_value(); ?>' >
						<h2 class='edit_midasi'>
							予約メール内容
						</h2>
						<textarea  name='<?php echo self::yoyaku_mail_content_name; ?>'><?php echo $c->YoyakuMailContent->get_value(); ?></textarea>
					</div>
				</div>
			</div>
		</form>
		<?php
	}
	
	public function get_name()
	{
		return "mail_setting";
	}
	
	public function get_title_name()
	{
		return "予約メール設定";
	}
	
}

?>