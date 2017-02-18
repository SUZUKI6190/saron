<?php
namespace ui\publish;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once("publish-menu-new.php");
require_once("publish-menu-edit.php");
use \business\facade;
use \business\entity\Menu;
use \ui\util\SubmitButton;
use \ui\frame\Result;

class MenuSub extends \ui\frame\SubCategory
{
	private $_menu_list;
	private $_form_id = "menu_form";
	public function __construct()
	{
		$this->_menu_list = array_map(function($menu){
			return new ViewMenuDetailEdit($menu, $this->_form_id);
		}, \business\facade\get_menu_list());
	}
	public function view()
	{
		foreach($this->_menu_list as $menu)
		{
			$menu->view();
		}
	}
	
	public function get_name()
	{
		return "menu";
	}
	
	public function get_title_name()
	{
		return "メニュー設定";
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