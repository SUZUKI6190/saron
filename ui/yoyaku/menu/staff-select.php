<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\YoyakuContext;
use business\entity\Staff;
use ui\image\ImageDonwloader;

require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;

class StaffSelect extends YoyakuMenu
{
	private $_staff_list = [];
	private $_course_id_list = [];
	private $_form_id = 'rest_form';

	private $course_table;

	const back_btn_name = "back_btn";
	const next_btn_name = "staff_id";
	
	private function get_therapist_url() : string
	{
		return 'http://redear.jp/therapist/';
	}

	protected function get_css_list() : array
	{
		return ["staff.css","course-table.css"];
	}

	public function __construct()
	{

	}

	protected function init_inner()
	{
		$yc = YoyakuContext::get_instance();
		$this->_staff_list = \business\facade\get_staff_all();
		$this->_course_id_list = $this->get_course_id_list();

		$course_list = \business\facade\get_menu_course_by_idlist($this->_course_id_list);
		$this->course_table = new CourseTable($course_list);
	}

	public function pre_render()
	{
		$url =  get_bloginfo('url')."/".get_query_var( 'pagename' )."/yoyaku/day/";
		$yc = YoyakuContext::get_instance();
		$before_url = $yc->get_base_url()."/menu/".$this->get_menu_id();
  		
		if(isset($_POST[self::back_btn_name])){
            $this->transfer($before_url);
        }

		if($this->is_move_next())
		{
			$this->transfer($url);
		}
	}

	private function is_move_next():bool
	{
		return isset($_POST[self::next_btn_name]);
	}

	public function get_title() : string
	{
		return "セラピスト選択";
	}

	private function view_staff_info(Staff $s)
	{
		$img = new ImageDonwloader('staff', $s->id);
		$img->css_class = 'staff_image';
		?>
		<div class='staff_info'>
			<div class='staff_image_wrap'>
				<?php $img->view(); ?> 
			</div>
			<div class='staff_name'>
				<a class='staff_name_link' href='<?php echo $s->introduce_page_url;?>'><?php echo $s->name_last.' '.$s->name_first ?></a>
			</div>
			<div class='select_staff_button_area'>
				<button type='submit' value='<?php echo $s->id; ?>' name='<?php echo self::next_btn_name; ?>' class='next_button'>指名して予約</button>
			</div>
		</div>
		<?php
		$s->name_first;
	}

	public function view()
	{
		?>
		<div class='staff_wrap'>				
			<?php $this->view_yoyaku_frame_hidden(); ?>
			<div class = 'yoyaku_midashi'>
				<span>セラピストを選択してください</span>
			</div>
			<div class='course_table_area'>
			<?php
			$this->course_table->view();
			?>
			</div>
			<div class='reserve_area'>
				<button type='submit' value='none' name='<?php echo self::next_btn_name; ?>' class='next_button'>指名せず予約する</button>
			</div>
			<div class='staff_select_area'>
			<?php
			foreach($this->_staff_list as $s)
			{
				$this->view_staff_info($s);
			}
			?>
			</div>
	
			<div class='back_button_area'>
				<?php $this->view_yoyaku_frame_hidden(); ?>
				<div class='back_button_area'>
					<input type ='submit' name='<?php echo self::back_btn_name; ?>' value="戻る" class="back_button">
				</div>					
			</div>
		</div>

		<?php
	}
}

?>