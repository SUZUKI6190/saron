<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/staff.php');
require_once(dirname(__FILE__).'/../../business/entity/staff.php');
require_once('staff-input-form.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputBase;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use ui\image\ImageDonwloader;

class StaffAddNewSub extends \ui\frame\SubCategory
{
	private $_input_form;
	public function init()
	{
		$context = StaffContext::get_instance();
		if(empty($context->staff_id)){
			$this->_input_form = new StaffInputFormNew();
		}else{
			$this->_input_form = new StaffInputFormEdit();
		}
	}
	public function view()
	{
		$this->_input_form->view();
	}
	public function get_name()
	{
		return "edit";
	}
	
	public function get_title_name()
	{
		return "スタッフを追加";
	}
	
	public function get_result() : Result
	{
		$ret =  new Result();
		if($this->_input_form->is_save())
		{
			$ret->message = "スタッフの変更を保存しました。";
			$ret->set_regist_state(true);
		}
		return $ret;
	}

	public function regist()
	{
		$this->_input_form->save();
	}
}

class StaffViewSub extends \ui\frame\SubCategory
{
	private $_staff_list = [];
	private $_form_id = "staff_form";
	private $_delete_button_list = [];
	private $_new_staff_button;
	public function init()
	{
		$this->_staff_list = \business\facade\get_staff_all();
		foreach($this->_staff_list as $staff)
		{
			$this->_delete_button_list[$staff->id] = new ConfirmSubmitButton($staff->id, "削除", $this->_form_id);
		}

		$this->deleate_staff();

		$context = StaffContext::get_instance();
		if(empty($context->staff_id)){
			$this->_selected_staff = Staff::get_empty_object();
		}else{
			$this->_selected_staff = \business\facade\get_staff_byid($context->staff_id);
		}

	}

	private function deleate_staff()
	{
		foreach($this->_delete_button_list as $id => $db)
		{
			if($db->is_submit())
			{
				\business\facade\delete_staff($id);
			}
		}
	}

	public function view()
	{
		$mc = ManageFrameContext::get_instance();
		$url = $mc->get_url()."/staff/edit/";
		?>
		<form method="post" id='<?php echo $this->_form_id; ?>' >
	
		<div class="centering">
			
			<div class='staff_wrap'>			
		
				<?php
				foreach($this->_staff_list as $staff)
				{
					$img = new ImageDonwloader('staff', $staff->id);
					$img->css_class= 'staff_image_view';
					$name = $staff->name_last.' '.$staff->name_first;
					$msg = $name."を削除します。よろしいですか？";
					?>
					<div class='staff_info'>
						<div class='image_area'>
							<?php $img->view(); ?>
						</div>
						<div class='name_area'>
							<?php
							echo $name;
							?>
						</div>
						<div class='edit_area'>
							<?php
							\ui\util\link_button("編集", $url."/".$staff->id);
							$db = $this->_delete_button_list[$staff->id];
							$db->set_message($msg);
							$db->view();
							?>
						</div>

					</div>
					<?php
				}
				?>

			</
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
		return "スタッフ一覧";
	}
	
}

?>