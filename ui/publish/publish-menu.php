<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu-course.php');
use \ui\util\SubmitButton;
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

abstract class ViewMenuDetail
{
	private $_add_course_button;
	private $_menu;
	private $_form_id;
	public function __construct(Menu $menu)
	{
		$this->_menu = $menu;
		$this->_add_course_button = new SubmitButton('コースを追加する', "add_course", $this->_form_id);
	}
	
	public abstract function save_inner();

	public function view()
	{?>
		<div style="text-align:right;">
            <input type="submit"  value="+メニューを追加する"/>
        </div>
        <div class="menu_midasi">
            <div>メニュー設定</div>
        </div>
		<div>メニュー名</div>
		<?php echo $this->_menu->name; ?>
		<div>価格</div>
		<?php echo $this->_menu->price; ?>
		<div>所要目安時間</div>
		<?php echo $this->_menu->time_required; ?>
		<div>コース</div>
	<?php
		foreach($this->_menu->course_list as $couse)
		{?>
			
		<?php
		}
	}
}

?>