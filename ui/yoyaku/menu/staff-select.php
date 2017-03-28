<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
use business\entity\Staff;

class StaffSelect extends YoyakuMenu
{
	private $_staff_list = [];
	private $_form_id = 'rest_form';

	public function __construct()
	{
		$yc = YoyakuContext::get_instance();
		$this->_staff_list = \business\facade\get_staff_all();
		$id_list = $_POST['course_id'];
		
		print_r($_POST);
	}

	public function get_title() : string
	{
		return "セラピスト選択";
	}

	private function view_staff_info(Staff $s)
	{
		?>
		<div class='staff_info'>
			<div class='staff_image_wrap'>
				<img class='staff_image' src='<?php echo $s->image; ?>' />
			</div>
			<div class='staff_name'>
				<span><?php echo $s->name_last.' '.$s->name_first ?></span>
			</div>
		</div>
		<?php
		$s->name_first;
	}

	public function view()
	{
		?>
		<div class = 'yoyaku_midashi'>
			<span>セラピストを選択してください</span>
		</div>

		<div class='staff_select_area'>
		<?php
		foreach($this->_staff_list as $s)
		{
			$this->view_staff_info($s);
		}
		?>
		</div>
		<?php
	}
}

?>