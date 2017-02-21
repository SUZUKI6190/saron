<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../../business/entity/menu-course.php');
require_once('publish-menu.php');
use \business\entity\MenuCourse;
use \ui\util\SubmitButton;

abstract class MenuCourseForm
{
	private $_menu_id;
	protected $_form_id;
	protected $_name, $_time_required, $_price;
	protected $_add_course_button;
	public function __construct($menu_course, $menu_id, $form_id)
	{
		$this->_menu_id = $menu_id;
		$this->_form_id = $form_id;
		$this->_name = new PublishMenuInput("text", "course_name", $menu_course->name);
		$this->_time_required = new PublishMenuInput("numeric", "course_time_required", $menu_course->time_required);
		$this->_price = new PublishMenuInput("numeric", "course_price", $menu_course->price);
		$this->_add_course_button = new SubmitButton("regist_course" ,'登録する', $this->_form_id);
	}
	
	public function is_save() : bool
	{
		return $this->_add_course_button->is_submit();
	}
	
	public function view()
	{
		?>
		<div class="input_form">
			<div class="line">
				<div>コース名</div>
				<?php $this->_name->view(); ?>
			</div>
			<div class="line">
				<div>所要目安時間</div>
				<?php $this->_time_required->view(); ?>
			</div>
			<div class="line">
				<div>価格</div>
				<?php $this->_price->view(); ?>
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
}

?>