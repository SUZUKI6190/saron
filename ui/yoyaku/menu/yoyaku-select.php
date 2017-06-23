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
	private $_checkbox_id_list = [];
	const ChkBoxIdListId = 'chk_list_id';
	const CheckCourseMsg = 'コースを選択してください';
	
	const NextBtnName = "next_button";

	protected function get_css_list() : array
	{
		return ["menu-table.css"];
	}

	protected function get_js_list() : array
	{
		return ["menu-select.js"];
	}

	protected function init_inner()
	{


		$yc = YoyakuContext::get_instance();
		$this->_menu_list = \business\facade\get_menu_list();
		$selected = [];
		$rest = [];
	
		$this->_next_button = new SubmitButton('next_button', "この内容で次へ" , 'te', 'next_button');	
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
			$this->_checkbox_id_list = array_merge($this->_checkbox_id_list, $this->_selected_menu_table->get_checkbox_id_list());
			$this->_checkbox_id_list = array_merge($this->_checkbox_id_list, $this->_rest_menu_table->get_checkbox_id_list());
			$this->set_menu_id((int)$yc->menu_id);	
		}else{
			foreach($this->_menu_list as $menu)
			{
				$menu->course_list = \business\facade\get_menu_course_by_menuid($menu->menu_id);
				$rest[] = $menu;
			}
			$this->_rest_menu_table = new MenuTable($rest, "rest", 'メニューを選択してください', $this->_form_id);
			$this->_checkbox_id_list = $this->_rest_menu_table->get_checkbox_id_list();
		}
	}

	public function pre_render()
	{
		if($this->is_move_next())
		{
			$yc = YoyakuContext::get_instance();
			$d = "?date=".(new \DateTime())->format("Ymdhis");
			$url =  get_bloginfo('url')."/".get_query_var( 'pagename' )."/yoyaku/staff/".$d;
            header("Location:$url");
		}
	}
	
	public function get_title() : string
	{
		return "メニュー選択";
	}
	
	private function is_move_next():bool
	{
		return isset($_POST[self::NextBtnName]);
	}

	private function view_next_button()
	{
		?>
		<input type='submit' value="この内容で次へ" name="<?php echo self::NextBtnName; ?>" class="manage_button next_button" onclick='return select_check("<?php echo self::ChkBoxIdListId; ?>", "<?php echo self::CheckCourseMsg; ?>");' />
		<?php
	}
	
	public function view()
	{
		$d = "?date=".(new \DateTime())->format("Ymdhis");
		?>
		<input type='hidden' value=<?php echo implode(',', $this->_checkbox_id_list); ?> id='<?php echo self::ChkBoxIdListId; ?>' />
		<form method='post' action='<?php echo "$d" ?>' >
			<?php 
			if(!empty($yc->menu_id)){
				?>
				<div class='yoyaku_selected_area'>
				<?php $this->_selected_menu_table->view(); ?>
				</div>
								
				<div class='next_button_area'>
					<?php $this->view_next_button(); ?>
				</div>
			
			<?php
			}
			?>
			<div class='yoyaku_all_area'>
				<?php $this->_rest_menu_table->view(); ?>
			</div>
			
			<div class='next_button_area'>
				<a href='' class="back_button" >戻る</a>	
				<?php $this->view_next_button(); ?>
			</div>
			<?php $this->view_yoyaku_frame_hidden(); ?>
		</form>	
	<?php
	}
}

?>