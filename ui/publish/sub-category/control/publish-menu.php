<?php
namespace ui\publish;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\InputTextarea;
use \business\entity\Menu;
use \business\entity\MenuCourse;

use \ui\IEdit;

class MenuCourseView
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
	public function __construct($type, $name, $value, $style = "", $add_atribute = [])
	{
		$css_class = "publish_menu ".$style;
		parent::__construct($type, $name, $value, $css_class, $add_atribute);
	}
}

abstract class ViewMenuDetail implements IEdit
{
	protected $_menu;
	protected $_form_id;
	protected $_menu_name, $_description;
	public function __construct($form_id)
	{
		$this->_form_id = $form_id;
		$this->_menu = $this->get_default_menu();
		
		$this->_regist_menu_button = new SubmitButton("regist_menu" ,'登録する', $this->_form_id);
		
		$required_attr = [];
		$required_attr["required"] = "";
		
		$this->_menu_name = new PublishMenuInput("text", "name", $this->_menu->name, "", $required_attr);
		$this->_description = new InputTextarea("description", $this->_menu->description, "menu_description");
	}
	
	protected abstract function save_inner(Menu $menu);

	protected abstract function get_default_menu(): Menu;
	
	public function is_save() : bool
	{
		return $this->_regist_menu_button->is_submit();
	}
	
	public function save()
	{
		$this->save_inner($this->create_menu());
	}
	
	private function create_menu() : Menu
	{
		$menu = new Menu();
		$menu->name = $this->_menu_name->get_value();
		$menu->description = $this->_description->get_value();
		
		return $menu;
	}
	
	public function view()
	{
		?>
		<div class="input_form">
		<div>
		<?php $this->_regist_menu_button->view(); ?>
		</div>
		<div class="line">
			<div>メニュー名</div>
			<?php echo $this->_menu_name->view(); ?>
		</div>
		<div class="line">
			<div>説明</div>
			<?php echo $this->_description->view(); ?>
		</div>
		</div>
		<?php
	}
}

?>