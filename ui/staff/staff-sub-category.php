<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/staff.php');
require_once(dirname(__FILE__).'/../../business/entity/staff.php');
require_once('staff-input-form.php');
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;

class StaffAddNewSub extends \ui\frame\SubCategory
{
	private $_input_form;
	public function __construct()
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

	private $_new_staff_button;
	public function __construct()
	{
		$this->_staff_list = \business\facade\get_staff_all();
		$context = StaffContext::get_instance();
		
		if(empty($context->staff_id)){
			$this->_selected_staff = Staff::get_empty_object();
		}else{
			$this->_selected_staff = \business\facade\get_staff_byid($context->staff_id);
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
					?>
					<table class="staff_view_table">
					<tr>
						<th>氏名</th>
						<td class="menu_name">
							<?php
							echo $staff->name_last.' '.$staff->name_first;
							?>
						</td>
					</tr>
					<tr>
						<th>電話番号</th>
						<td class="menu_edit">
						<?php
							echo $staff->tell;
						?>
						</td>
					</tr>
					<tr>
						<th>email</th>
						<td class="menu_edit">
						<?php
							echo $staff->email;
						?>
						</td>
					</table>
					<div class='edit_area'>
					<?php
					\ui\util\link_button("編集", $url."/".$staff->id);
					?>
					<div>
					<?php
				}
				?>

			</div>
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