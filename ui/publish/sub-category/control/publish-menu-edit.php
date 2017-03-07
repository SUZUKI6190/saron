<?php
namespace ui\publish;
require_once('publish-menu.php');
require_once('publish-course.php');
use \business\entity\Menu;
use \business\entity\MenuCourse;
use ui\frame\ManageFrameContext;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputBase;
use \ui\publish\MenuCourseNew;
use \ui\publish\MenuCourseForm;

class ViewMenuDetailEdit extends ViewMenuDetail
{
	private $_delete_course_button_list = [];
	private $_edit_course_button_list = [];
	private $_add_course_button;
	public function __construct($form_id)
	{
		parent::__construct($form_id);
		$this->_delete_button = new ConfirmSubmitButton("delete_menu" ,'削除', $this->_form_id, "本当に削除しますか？");
	}

	public function save_inner(Menu $menu)
	{
		$pc = PublishContext::get_instance();
		\business\facade\delete_menu($pc->menu_id);
		\business\facade\insert_menu($menu);		
	}

	protected function get_default_menu() : Menu
	{
		$pc = PublishContext::get_instance();
		$menu = \business\facade\get_menu_by_id($pc->menu_id);
		$menu->course_list = \business\facade\get_menu_course_by_menuid($pc->menu_id);
		return $menu;
	}
	
	private function view_menu()
	{
		parent::view();
		$mc = ManageFrameContext::get_instance();
		$course_url = $url = $mc->get_url()."/publish/menu_regist/course/";
		$pc = PublishContext::get_instance();
		?>
		<div class="input_form">
		<div class="line">
			<div>コース</div>
			<?php \ui\util\link_button('新しいコースを追加する', $course_url."/".$this->_menu->menu_id ); ?>
			<table class="menu_table">
			<?php

			foreach($this->_menu->course_list as $course)
			{
			?>	
			<tr>
				<td class="menu_name">
					<?php echo $course->name; ?>
				</td>
			
			   <td class="menu_edit">
				<?php
					$url = $course_url.$pc->menu_id."/".$course->id;
					\ui\util\link_button("編集", $url);
					?>
                </td>
                <td class="menu_edit">
				<?php
					//$this->_delete_course_button_list[$course->id]->view();
				?>
                </td>        
			</tr>
			<?php
			}
			?>
			</table>
		</div>
		</div>
<?php
	}
	
	public function view()
	{
		$this->view_menu();
	}
	 
}

?>