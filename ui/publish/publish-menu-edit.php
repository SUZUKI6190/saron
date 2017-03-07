<?php
namespace ui\publish;
require_once('publish-menu.php');
require_once('publish-course.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
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
	private $_course_form;
	public function __construct($form_id)
	{
		parent::__construct($form_id);
		$this->_delete_button = new ConfirmSubmitButton("delete_menu" ,'削除', $this->_form_id, "本当に削除しますか？");
		$pc = PublishContext::get_instance();
		if(empty($pc->is_course_edit)){
			if(empty($pc->course_id)){
				$this->_course_form = new MenuCourseNew($pc->menu_id, $this->_form_id);
			}else{
				$this->_course_form = new MenuCourseEdit($pc->menu_id, $this->_form_id, $pc->course_id);
			}	
		}
	}

	public function save_inner(Menu $menu)
	{
		$pc = PublishContext::get_instance();
		if(empty($pc->is_course_edit)){
			\business\facade\delete_menu($pc->menu_id);
			\business\facade\insert_menu($menu);
		}else{
			$this->_course_form->save();
		}
	}

	public function is_save() : bool
	{
		if(empty($pc->is_course_edit)){
			return (parent::is_save());
		}else{
			return (parent::is_save()) or $this->_course_form->is_save();
		}
	}
	
	protected function get_default_menu() : Menu
	{
		$pc = PublishContext::get_instance();
		return \business\facade\get_menu_by_id($pc->menu_id);
	}

	public function view_course_form()
	{
		$pc = PublishContext::get_instance();
		
		if(empty($pc->course_id)){
			$this->_course_form = new MenuCourseNew($pc->menu_id, $this->_form_id);
		}else{
			$this->_course_form = new MenuCourseEdit($pc->menu_id, $this->_form_id, $pc->course_id);
		}
		
		$this->_course_form->view();	
	}
	
	private function view_menu()
	{
		parent::view();
		$mc = ManageFrameContext::get_instance();
		$course_url = $url = $mc->get_url()."/publish/menu_regist/course/";
		
		?>
		<div class="input_form">
		<div class="line">
			<div>コース</div>
			<?php \ui\util\link_button('新しいコースを追加する', $course_url."/".$this->_menu->menu_id ); ?>
			<table class="menu_table">
			<?php

			foreach($this->_menu->course_list as $couse)
			{
			?>	
			<tr>
				<td class="menu_name">
					<?php echo $couse->name; ?>
				</td>
			
			   <td class="menu_edit">
				<?php
					$url = $course_url.$menu->menu_id."/".$course->id;
					\ui\util\link_button("編集", $url);
					?>
                </td>
                <td class="menu_edit">
				<?php
					$this->_delete_course_button_list[$couse->id]->view();
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
		$pc = PublishContext::get_instance();

		if(empty($pc->is_course_edit)){
			$this->view_menu();
		}else{
			$this->view_course_form();
		}
	}
	 
}

?>