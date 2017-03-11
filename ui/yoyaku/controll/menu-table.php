<?php
namespace ui\yoyaku\controll;

class MenuTable
{
	private $_menu_list = [];
	public function __construct($menu_list)
	{
		$this->_menu_list = $menu_list;
	}
	
	public function view()
	{
		function td($value)
		{
			?>
			<td>
			<?php echo $value; ?>
			</td>
			<?php
		}
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
			td($menu->name);
			td('');
			td('');
			td('');
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
				td($course->time_required);
				td($course->price);
				td($course->first_discount);
				?>
				</tr>
				<?php
			}
		}
		?>
		</table>
	<?php
	}


}

?>