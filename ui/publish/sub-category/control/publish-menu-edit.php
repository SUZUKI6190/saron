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
use \ui\util\ButtonList;
use \ui\util\SubmitBase;
use \ui\publish\MenuCourseNew;
use \ui\publish\MenuCourseForm;

class DeleteButtonList extends ButtonList
{
	protected function create_button_key($data)
	{
		return $data->id;
	}
	
	protected function on_click_inner($key)
	{
		$pc = PublishContext::get_instance();
		\business\facade\delete_menu_course($key, $pc->menu_id);
	}
	
	protected function create_button($name, $data) : SubmitBase
	{
		return new ConfirmSubmitButton($name, '削除', $this->_form_id, "本当に削除しますか？");
	}

}

class ViewMenuDetailEdit extends ViewMenuDetail
{
	private $_delete_course_button_list = [];
	private $_edit_course_button_list = [];
	private $_add_course_button;
	private $_delete_button_list;
	public function __construct($form_id)
	{
		parent::__construct($form_id);
		$this->_delete_button = new ConfirmSubmitButton("delete_menu" ,'削除', $this->_form_id, "本当に削除しますか？");
		$this->_delete_button_list = new DeleteButtonList($form_id, "course_delete", $this->_menu->course_list);
	}

	public function is_save() : bool	
	{
		if($this->_delete_button_list->is_submit()){
			return true;
		}else{
			return parent::is_save();
		}
	}

	public function save_inner(Menu $menu)
	{
		if($this->_delete_button_list->is_submit()){
			$this->_delete_button_list->on_click();
			return;
		}

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
		<div class="input_form course_view_form">
		<div class="line">
			<h2>コース</h2>
			<?php \ui\util\link_button('新しいコースを追加する', $course_url."/".$this->_menu->menu_id ); ?>
			<table class="course_view">
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
	
				?>
					<a href='<?php echo $url; ?>'>
						<input type='button' class='manage_button' value='編集' />
					</a>
                </td>
                <td class="menu_edit">
				<?php
					//$this->_delete_course_button_list[$course->id]->view();
					$this->_delete_button_list->get_button($course->id)->view();
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