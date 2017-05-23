<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/control/publish-course.php');
require_once(dirname(__FILE__).'/control/publish-iedit-factory.php');
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

class MenuNewAddSub extends \ui\frame\SubCategory
{
	private $_view_menu_new;
	private $_regist_menu_button;
	private $_form_id = "menu_form";
	public function init()
	{
		$this->_view_menu_new = create_publish_edit($this->_form_id);
	}
	public function view()
	{?>
		<form id='<?php echo $this->_form_id; ?>' method='post' >
		<?php $this->_view_menu_new->view(); ?>
		</form>
		<?php
	}

	public function get_name()
	{
		return "menu_regist";
	}
	
	public function get_title_name()
	{
		return "新しいメニューを追加";
	}
	
	public function get_result() : Result
	{
		$ret =  new Result();
		if($this->_view_menu_new->is_save())
		{
			$ret->message = "メニューの登録を完了しました。";
			$ret->set_regist_state(true);
		}
		return $ret;
	}
	
	public function regist()
	{
		$this->_view_menu_new->save();
	}
}
?>