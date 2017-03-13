<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;

class YoyakuSelect extends YoyakuMenu
{
	private $_selected_menu_table;
	private $_rest_menu_table;
	private $_menu_list = [];
	private $_selected_list = [];
	private $_form_id = 'rest_form';
	public function __construct()
	{
		$yc = YoyakuContext::get_instance();
		$this->_menu_list = \business\facade\get_menu_list();
		$selected = [];
		$rest = [];
		foreach($this->_menu_list as $menu)
		{
			$menu->course_list = \business\facade\get_menu_course_by_menuid($menu->menu_id);
			if($menu->menu_id == $yc->menu_id)
			{
				$selected[] = $menu;
			}else{
				$rest[] = $menu;
			}
		}
		$this->_selected_menu_table = new MenuTable($selected, $this->_form_id);
		$this->_rest_menu_table = new MenuTable($rest, $this->_form_id);
	}
	public function view()
	{?>
		<div class='yoyaku_selected_area'>
		<?php  ?>
		</div>
		<form method='post' id='<?php echo $this->_selected_form_id; ?>' >
			<div class='yoyaku_all_area'>
			<?php $this->_selected_menu_table->view(); ?>
			</div>
		</form>
		<form method='post' id='<?php echo $this->_rest_form_id; ?>' >
		<div class='yoyaku_all_area'>
			<?php $this->_rest_menu_table->view(); ?>
		</div>
		</form>
	<?php
	}
}

?>