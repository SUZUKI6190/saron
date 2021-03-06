<?php
namespace ui\publish;
require_once("control/publish-menu-new.php");
require_once("control/publish-menu-edit.php");
require_once('control/publish-course.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\Menu;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\publish\PublishContext;
use \business\entity\MenuCourse;
use \ui\publish\MenuCourseNew;
use \ui\publish\MenuCourseForm;

class PublishDeleteButton extends ConfirmSubmitButton
{
	public $id;
}

class MenuSub extends \ui\frame\SubCategory
{
	private $_menu_list = [];
	private $_form_id = "menu_form";
	private $_edit_form_id = "edit_menu_form";
	private $_edit_form_name = "edit_menu_form_name";
	private $_view_menu;
	private $_delete_button_list = [];

	public function init()
	{
		foreach(\business\facade\get_menu_list() as $menu)
		{
			foreach(\business\facade\get_menu_course_by_menuid($menu->menu_id) as $course)
			{
				$menu->course_list[] = $course;
				$this->_delete_course_button_list[$course->id] = new ConfirmSubmitButton("delete_course_".$course->id ,'削除', $this->_form_id, "本当に削除しますか？");
			}
			$this->_menu_list[$menu->menu_id] = $menu;
		}
		foreach($this->_menu_list as $menu)
		{
			$this->_delete_button_list[$menu->menu_id] = new ConfirmSubmitButton("delete_menu_".$menu->menu_id ,'削除', $this->_form_id, "本当に削除しますか？");
		}
		$this->_delete_button = new ConfirmSubmitButton("delete_menu" ,'削除', $this->_form_id, "本当に削除しますか？");
		$pc = PublishContext::get_instance();
		

	}
	
	public function view_menu_form()
	{
		$pc = PublishContext::get_instance();
		$mc = ManageFrameContext::get_instance();
		$d = "?date=".(new \DateTime())->format("Ymdhis");
		?>
	
		<table class="menu_table">
		<?php
		foreach($this->_menu_list as $key => $menu)
		{
			?>
			<tr>
				<td class="menu_name">
					<?php echo $menu->name; ?>
				</td>
                <td class="menu_edit">
				<?php
					$url = $mc->get_url()."/publish/menu_regist/".$menu->menu_id.$d;
					?>
					<a href='<?php echo $url; ?>'>
					<input type='button' class='manage_button' value='編集' />
					</a>
					<?php
				
				?>
                </td>
                <td class="menu_edit">
				<?php
					$this->_delete_button_list[$menu->menu_id]->view();
				?>
                </td>        
			</tr>
			<tr>
				<td class='menu_url_row' colspan="3">
				<?php
					$menu_url = $mc->get_url()."/yoyaku/menu/".$menu->menu_id.$d;
				?>
				<a href = '<?php echo $menu_url; ?>'>
				<?php echo $menu_url; ?>
				</a>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		
		<?php
		
	}

	public function view()
	{
		?>
		<form id='<?php echo $this->_edit_form_id; ?>' name='<?php echo $this->_edit_form_name; ?>' method='post'>
		<?php
		$pc = PublishContext::get_instance();
		$this->view_menu_form();
		?>
		</form>
		<?php
	}
	public function get_result() : Result
	{
		$ret =  new Result();
		
		foreach($this->_delete_button_list as $key => $button)
		{
			if($button->is_submit())
			{
				$ret->message = "メニューを削除しました。";
				$ret->set_regist_state(true);
				return $ret;
			}
		}
		return $ret;
	}
	public function get_name()
	{
		return "menu";
	}
	
	public function get_title_name()
	{
		return "メニュー設定";
	}
		
	public function regist()
	{
		$pc = PublishContext::get_instance();

		foreach($this->_delete_course_button_list as $key => $button)
		{
			if($button->is_submit())
			{
				\business\facade\delete_menu_course($key, $pc->menu_id);
			}
		}
		
		foreach($this->_delete_button_list as $key => $button)
		{
			if($button->is_submit())
			{
				\business\facade\delete_menu($key);
			}
		}
	}
}

?>