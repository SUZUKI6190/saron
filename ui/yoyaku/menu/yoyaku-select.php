<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;

class YoyakuSelect extends YoyakuMenu
{
	private $_selected_menu_table;
	private $_rest_menu_table;
	private $_menu_list = [];
	private $_selected_list = [];
	private $_form_id = 'rest_form';
	private $_next_button, $_back_button;
	public function __construct()
	{

		$yc = YoyakuContext::get_instance();
		$this->_menu_list = \business\facade\get_menu_list();
		$selected = [];
		$rest = [];
		$this->_next_button = new SubmitButton('next_button', "この内容で次へ" , '', 'next_button');	
		if(!empty($yc->menu_id)){
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
			$this->_selected_menu_table = new MenuTable($selected, "selected", 'メニューを選択してください', $this->_form_id);
			$this->_rest_menu_table = new MenuTable($rest, "rest", '追加メニューご希望の方はメニューを選択してください', $this->_form_id);
		}else{
			foreach($this->_menu_list as $menu)
			{
				$menu->course_list = \business\facade\get_menu_course_by_menuid($menu->menu_id);
				$rest[] = $menu;
			}
			$this->_rest_menu_table = new MenuTable($rest, "rest", 'メニューを選択してください', $this->_form_id);
		}		
	}
	
	public function get_title() : string
	{
		return "メニュー選択";
	}
	
	public function view()
	{
		$yc = YoyakuContext::get_instance();
		$url =  get_bloginfo('url')."/".get_query_var( 'pagename' )."/yoyaku/staff/";
		?>
		<form method='post' action='<?php echo $url; ?>' >
			<?php 
			if(!empty($yc->menu_id)){
				?>
				<div class='yoyaku_selected_area'>
				<?php $this->_selected_menu_table->view(); ?>
				</div>
								
				<div class='next_button_area'>
			
				<?php
				$this->_next_button->view();
				?>
				
				</div>
			
			<?php
			}
			?>
			<div class='yoyaku_all_area'>
				<?php $this->_rest_menu_table->view(); ?>
			</div>
			
			<div class='next_button_area'>
			<form method='post' action='' >
				<input type='submit' value="戻る" name="back_button" class="back_button"  />
			</form>
		
			<?php
				$this->_next_button->view();
			?>

			</div>
		</form>	
	<?php
	}
}

?>