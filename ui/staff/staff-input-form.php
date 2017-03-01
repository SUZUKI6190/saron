<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../../business/entity/staff.php');
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/staff.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\InputBase;

abstract class StaffInputFormBase
{
	private $_staff;
	private $_name_first, $_name_last, $_tell, $_email;
	private $_save_button;
	private $_form_id = "staff_input_form";
	public function __construct()
	{
		$this->_staff = $this->create_staff();
		$required_attr = [];
		$required_attr["required"] = "";
		$this->_save_button = new SubmitButton("save_button", "保存する", $this->_form_id);
		$this->_name_first = new InputBase("text", "name_first", $this->_staff->name_first, "" ,$required_attr);
		$this->_name_last = new InputBase("text", "name_last", $this->_staff->name_last, "", $required_attr);
		$this->_tell = new InputBase("number", "tell", $this->_staff->tell);
		$this->_email = new InputBase("email", "email", $this->_staff->email);
	}

	protected abstract function innser_save(Staff $staff);
	protected abstract function create_staff() : Staff;
	
	public function save()
	{
		$this->innser_save($this->_staff);
	}
	
	public function is_save() : bool
	{
		return $this->_save_button->is_submit();
	}
	
	public function view()
	{
		?>
		<form method="post" id='<?php echo $this->_form_id; ?>' >
		<div class="input_form">
		<div class="staff_form_button">
		<?php $this->_save_button->view(); ?>
		</div>
		<div class="line">
			<div>名前(性)</div>
			<?php echo $this->_name_last->view(); ?>
		</div>
		<div class="line">
			<div>名前(名)</div>
			<?php echo $this->_name_first->view(); ?>
		</div>
		<div class="line">
			<div>電話番号</div>
			<?php echo $this->_tell->view(); ?>
		</div>
		<div class="line">
			<div>email</div>
			<?php echo $this->_email->view(); ?>
		</div>
		</div>
		</form>
		<?php

	}
}

class StaffInputFormNew extends StaffInputFormBase
{
	protected function innser_save(Staff $staff)
	{
	}
	
	protected function create_staff() : Staff
	{
		return Staff::get_empty_object();
	}
}

?>