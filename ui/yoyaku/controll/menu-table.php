<?php
namespace ui\yoyaku\controll;
use ui\util\SubmitButton;
class MenuTable
{
	private $_menu_list = [];
	private $_next_button;
	public $_form_id;
	public function __construct($menu_list, $name)
	{
		$this->_menu_list = $menu_list;
		$this->_form_id = $name;
		$this->_next_button = new SubmitButton('next_button', "この内容で次へ" , $this->_form_id, 'next_button');
	}
	
	public function get_checked_course() : MenuCourse
	{
	}

	private function td($value)
		{
			?>
			<td>
			<?php echo $value; ?>
			</td>
			<?php
		}
	
	public function view()
	{
		?>
		<table class='menu_view_table'>
		<thead>
		<tr class='menu_header'>
			<th>
				選択メニュー
			</th>

			<th>
				所要時間(目安)
			</th>
			<th>
				料金
			</th>
			<th>
				初回割引
			</th>
		</tr>
		</thead>
		<?php
		foreach($this->_menu_list as $menu)
		{
			?>
			<tr class='menu_row'>
			<?php		
			$this->td($menu->name);
			$this->td('');
			$this->td('');
			$this->td('');
			?>
			</tr>
			<?php
			foreach($menu->course_list as $course)
			{
				$id = $course->id;
				$row_id = "row_".$id;
				?>
				<tr class='course_row' id = '<?php echo $row_id; ?>'>
				<td>
				<input type='checkbox' id = '<?php echo $id; ?>' name = '<?php echo $id; ?>' onchange = 'on_check_menu("<?php echo $row_id; ?>", "<?php echo $id; ?>")' >
				<?php echo $course->name; ?>
				</td>
				<?php
				$this->td($course->time_required);
				$this->td($course->price);
				$this->td($course->first_discount);
				?>
				</tr>
				<?php
			}
		}
		?>
		</table>

		<div class='next_button_area'>
		<?php
		$this->_next_button->view();
		?>
		</div>
	
	<?php
	}
}

?>