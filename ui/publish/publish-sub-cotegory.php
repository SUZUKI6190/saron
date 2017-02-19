<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once("publish-menu-new.php");
require_once("publish-menu-edit.php");
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\Menu;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\publish\PublishContext;

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
	public function __construct()
	{
		foreach(\business\facade\get_menu_list() as $menu)
		{
			$this->_menu_list[$menu->menu_id] = $menu;
		}
		foreach($this->_menu_list as $menu)
		{
			$this->_delete_button_list[$menu->menu_id] = new ConfirmSubmitButton("delete_menu_".$menu->menu_id ,'削除', $this->_form_id, "本当に削除しますか？");
		}
		$this->_delete_button = new ConfirmSubmitButton("delete_menu" ,'削除', $this->_form_id, "本当に削除しますか？");
	}
	public function view()
	{
		$pc = PublishContext::get_instance();
		$mc = ManageFrameContext::get_instance();
		$main_cate = $mc->get_selected_main_category();
		?>
		<div class="setting_width centering">
		<form id='<?php echo $this->_edit_form_id; ?>' name='<?php echo $this->_edit_form_name; ?>' method='post'>
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
					$url = $mc->get_url()."/publish/menu/".$menu->menu_id;
					\ui\util\link_button("編集", $url);
				?>
                </td>
                <td class="menu_edit">
				<?php
					$this->_delete_button_list[$menu->menu_id]->view();
				?>
                </td>        

			</tr>
			<?php
		}
		?>
		</table>
		</form>
		</div>
		<?php
		if(!empty($pc->menu_id))
		{
			$id = $pc->menu_id;
			$menu = array_values(array_filter($this->_menu_list , function($menu) use($id){
				return $menu->menu_id == $id;
			}));
			$this->_view_menu = new ViewMenuDetailNew($menu[0] , $this->_form_id);
			$this->_view_menu->view();
		}
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
		foreach($this->_delete_button_list as $key => $button)
		{
			if($button->is_submit())
			{
				\business\facade\delete_menu($key);
			}
		}
	}
}

class MenuNewAddSub extends \ui\frame\SubCategory
{
	private $_view_menu_new;
	private $_regist_menu_button;
	private $_form_id = "menu_form";
	public function __construct()
	{
		$this->_regist_menu_button = new SubmitButton("regist_menu" ,'新しいメニューを登録する', $this->_form_id);
		$this->_view_menu_new = new ViewMenuDetailNew(Menu::get_empty_object(), $this->_form_id);
	}
	public function view()
	{?>
		<form id='<?php echo $this->_form_id; ?>' method='post' >
		<div>
		<?php $this->_regist_menu_button->view(); ?>
		</div>
		<?php $this->_view_menu_new->view(); ?>
		</form>
		<?php
	}

	public function get_name()
	{
		return "addnew";
	}
	
	public function get_title_name()
	{
		return "新しいメニューを追加";
	}
	
	public function get_result() : Result
	{
		$ret =  new Result();
		if($this->_regist_menu_button->is_submit())
		{
			$ret->message = "新しいメニューを登録しました。";
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