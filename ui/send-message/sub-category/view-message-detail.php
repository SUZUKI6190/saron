<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../frame/manage-frame.php');
require_once(dirname(__FILE__)."/../../staff.php");
require_once(dirname(__FILE__).'/../../../business/entity/send-message.php');
require_once(dirname(__FILE__).'/../../../business/facade/send-message.php');
require_once(dirname(__FILE__).'/send-mail-form-factory.php');
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
		$this->_day_count = new InputBase("number", $name, $day_value);
	}
	
	public function view()
	{?>
		<div class='<?php echo $setting_input_div_name ?>'>
			<?php $this->_day_count->view(); ?>
			日前に自動配信
		</div>
	<?php
	}

	public function get_day_num() : string
	{
		return $this->_day_count->get_value();
	}
	
}

abstract class ViewMessageDetail
{
	private $_default_msg;
	protected $_save_button;
	protected $_form_id = "msg_setting_input_form";
	protected $_input_form;
	const PageFlgKey = "MoveSettingForm";

	public function __construct()
	{
		$required_attr = [];
		$required_attr["required"] = "";
		$sc = SendMessageContext::get_instance();
		$this->_save_button = new SubmitButton("save_button", "保存する", $this->_form_id);
		$this->_default_msg = $sc->get_sendmessage();
		$this->_input_form = SendingFormFactory();
		$this->_input_form->set_msg($this->_default_msg);
		$this->_input_form->init();
	}
	
	public function save()
	{
		$msg =  SendMessageContext::get_instance()->get_sendmessage();
		$this->inner_save($msg);
	}

	protected abstract function inner_save(SendMessage $msg);
	
	protected abstract function add_button();

	public function is_save() : bool
	{
		return $this->_save_button->is_submit();
	}
	
	public function view()
	{
		?>
		<form id='<?php echo $this->_form_id; ?>' name="setting" method="post">
		<input type ='hidden' name='<?php echo self::PageFlgKey; ?>' value='0'>
		<?php
		$this->_input_form->view();
		?>
		<div class="msg_form_button">
			<?php
			$this->_save_button->view();
			$this->add_button();
			?>
		</div>
    	</form>
		<?php
	}

}

?>