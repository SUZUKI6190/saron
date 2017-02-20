<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu-course.php');
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\InputTextarea;
use \business\entity\Menu;
use \business\entity\MenuCourse;

class MenuCourseForm
{
	private $_course;
	private $_edit_button;
	private $_delete_button;
	public function __construct(MenuCourse $course, $form_id)
	{
		$this->_cours = $course;
		$this->_edit_button = new SubmitButton('編集', "edit_course_".$course->couse_id, $form_id);
		$this->_delete_button = new SubmitButton('削除', "delete_course_".$course->couse_id, $form_id);
	}
	const name_format = "%s（%d分）　%d円";
	public function view()
	{
		?>
		<div class="course_view">
		<?php echo sprintf(MenuCourse::$name_format, $this->name, $this->time_require, $this->price);?>
		</div>
		<?php
		$this->_edit_button.view();
		$this->_delete_button.view();
	}
}

class PublishMenuInput extends InputBase
{
	public function __construct($type, $name, $value, $style = "")
	{
		parent::__construct($type, $name, $value, "publish_menu ".$style);
	}
}

abstract class ViewMenuDetail
{
	private $_add_course_button;
	private $_menu;
	protected $_form_id;
	protected $_price, $_time_required, $_menu_name, $_description;
	public function __construct(Menu $menu, $form_id)
	{
		$this->_form_id = $form_id;
		$this->_menu = $menu;
		$this->_add_course_button = new SubmitButton("add_course" ,'新しいコースを追加する', $this->_form_id);
		$this->_menu_name = new PublishMenuInput("text", "name", $menu->name);
		$this->_time_required = new PublishMenuInput("numeric", "time_required", $menu->time_required);
		$this->_price = new PublishMenuInput("numeric", "price", $menu->price);
		$this->_description = new InputTextarea("description", $menu->description, "menu_description");
	}
	
	protected abstract function save_inner(Menu $menu);

	public function save()
	{
		$this->save_inner($this->create_menu());
	}
	
	private function create_menu() : Menu
	{
		$menu = new Menu();
		$menu->name = $this->_menu_name->get_value();
		$menu->time_required = $this->_time_required->get_value();
		$menu->price = $this->_price->get_value();
		$menu->description = $this->_description->get_value();
		
		return $menu;
	}
	
	public function view()
	{
		if($this->_add_course_button->is_submit())
		{
			return;
		}
		?>
		<div class="input_form">
	
		<div class="line">
			<div>メニュー名</div>
			<?php echo $this->_menu_name->view(); ?>
		</div>
		<div class="line">
			<div>価格</div>
			<?php echo $this->_price->view(); ?>
		</div>
		<div class="line">
			<div>所要目安時間</div>
			<?php echo $this->_time_required->view(); ?>
		</div>
		<div class="line">
			<div>説明</div>
			<?php echo $this->_description->view(); ?>
		</div>
		<div class="line">
			<div>コース</div>
			<?php
			$this->_add_course_button->view();
			foreach($this->_menu->course_list as $couse)
			{?>
			
			<?php
			}
			?>
		</div>
		</div>
		<?php
	}
}

?>