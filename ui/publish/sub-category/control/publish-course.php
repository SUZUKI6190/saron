<?php
namespace ui\publish;
require_once('publish-menu.php');
use \business\entity\MenuCourse;
use \ui\util\SubmitButton;

use \ui\IEdit;

abstract class MenuCourseForm implements IEdit
{
	protected $_menu_id;
	protected $_form_id;
	protected $_name, $_time_required, $_price, $_first_discount;
	protected $_add_course_button;
	public function __construct($menu_id, $form_id)
	{
		$this->_menu_id = $menu_id;
		$this->_form_id = $form_id;
		$menu_course = $this->get_default_course();
		$this->_name = new PublishMenuInput("text", "course_name", $menu_course->name, 'course_name');
		$this->_time_required = new PublishMenuInput("number", "course_time_required", $menu_course->time_required);
		$this->_price = new PublishMenuInput("number", "course_price", $menu_course->price);
		$this->_first_discount = new PublishMenuInput("number", "first_discount", $menu_course->first_discount);
		$this->_add_course_button = new SubmitButton("regist_course" ,'登録する', $this->_form_id);
	}
	
	public function is_save() : bool
	{
		return $this->_add_course_button->is_submit();
	}
	
	protected abstract function get_default_course() : MenuCourse;
	
	public function view()
	{
		?>
		<div class="input_form">
			<div class="line">
				<h2>コース名</h2>
				<?php $this->_name->view(); ?>
			</div>
			<div class="line">
				<h2>所要目安時間</h2>
				<?php $this->_time_required->view(); ?>
			</div>
			<div class="line">
				<h2>料金</h2>
				<?php $this->_price->view(); ?>
			</div>
			<div class="line">
				<h2>初回割引</h2>
				<?php $this->_first_discount->view(); ?>
			</div>
			<?php $this->_add_course_button->view(); ?>
		</div>
		<?php
	}

	public function save()
	{
		$this->save_inner($this->create_course());
	}

	private function create_course() : MenuCourse
	{
		$course = new MenuCourse();
		$course->menu_id = $this->_menu_id;
		$course->name = $this->_name->get_value();
		$course->time_required = $this->_time_required->get_value();
		$course->price = $this->_price->get_value();
		$course->first_discount = $this->_first_discount->get_value();
		return $course;
	}

	protected abstract function save_inner(MenuCourse $course);
}

class MenuCourseNew extends MenuCourseForm
{
	protected function save_inner(MenuCourse $course)
	{
		\business\facade\insert_menu_course($course);
	}
	protected function get_default_course() : MenuCourse
	{
		return MenuCourse::get_empty_object();
	}
}

class MenuCourseEdit extends MenuCourseForm
{
	private $_course_id;
	public function __construct($menu_id, $form_id, $course_id)
	{
		$this->_course_id = $course_id;
		parent::__construct($menu_id, $form_id);
	}

	protected function save_inner(MenuCourse $course)
	{
		\business\facade\delete_menu_course($this->_course_id, $course->menu_id);
		\business\facade\insert_menu_course($course);
	}
	
	protected function get_default_course() : MenuCourse
	{
		$ret = \business\facade\get_menu_course($this->_course_id, $this->_menu_id);
		return $ret;
	}
}

?>