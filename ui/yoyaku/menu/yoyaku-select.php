<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;

class YoyakuSelect extends YoyakuMenu
{
	private $_selected_menu_table;
	private $_all_menu_table;
	private $_menu_list;
	public function __construct()
	{
		$this->_menu_list = \business\facade\get_menu_list();
		$this->_all_menu_view = new MenuTable($this->_menu_list);
		foreach($this->_menu_list as $menu)
		{
			$menu->course_list = \business\facade\get_menu_course_by_menuid($menu->menu_id);
		}
	}
	public function view()
	{?>
		<div class='yoyaku_selected_area'>
		<?php  ?>
		</div>
		<div class='yoyaku_all_area'>
		<?php $this->_all_menu_view->view(); ?>
		</div>
	<?php
	}
}

?>