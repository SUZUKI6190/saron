<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../../business/entity/menu-course.php');
require_once('publish-menu.php');
use \business\entity\MenuCourse;

abstract class MenuCourseForm
{
	private $_menu_id;
	protected $_form_id;
	protected $_name, $_time_required, $_price;
	public function __construct($menu_course, $menu_id, $form_id)
	{
		$this->_menu_id = $menu_id;
		$this->_form_id = $form_id;
		$this->_name = new PublishMenuInput("text", "course_name", $menu_course->name);
		$this->_time_required = new PublishMenuInput("numeric", "course_time_required", $menu_course->time_required);
		$this->_price = new PublishMenuInput("numeric", "course_price", $menu_course->price);
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
		</div>
		<?php
	}

	public function save()
	{
		$this->save_inner($this->create_course());
	}

	private function create_course() : MenuCourse
	{
		$course = new Menu();
		$course->name = $this->_name->get_value();
		$course->time_required = $this->_time_required->get_value();
		$course->price = $this->_price->get_value();
		return $course;
	}

	protected abstract function save_inner$MenuCourse);
}

?>