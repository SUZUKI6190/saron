<?php
namespace ui\yoyaku\controll;
use ui\util\SubmitButton;
USE ui\util\InputBase;

class MenuTable
{
	private $_menu_list = [];
	private $_chk_list = [];
	private $_midasi = '';
	public function __construct($menu_list, $name, $midasi)
	{
		$this->_menu_list = $menu_list;
		$this->_midasi = $midasi;
		foreach($menu_list as $menu)
		{
			foreach($menu->course_list as $c)
			{
				$add_atribute = [];
				$row_id = "row_".$c->id;
				$onclick = sprintf ( 'on_check_menu("%s", "%d")', $row_id, $c->id);
				$add_atribute['onclick'] = $onclick;
				$add_atribute['id'] = $c->id;
				$this->_chk_list[$c->id] =  new InputBase('checkbox', $c->id, '', '', $add_atribute);
			}
		}
	}

	public function is_click_next_button():bool
	{
		return $this->_next_button->is_submit();
	}

	private function td($value, $class_name='')
	{
		?>
		<td class='<?php echo $class_name; ?>' >
		<?php echo $value; ?>
		</td>
		<?php
	}
	
	public function view()
	{
		?>
		<div class = 'menu_table_title'>
		<span><?php echo $this->_midasi ?></span>
		</div>
		<table class='menu_view_table'>
		<thead>
		<tr class='menu_header'>
			<th class='menu_name' rowspan='2'>
				選択メニュー
			</th>
			<th class='required_time' rowspan='2'>
				所要時間(目安)
			</th>
			<th class='price dummy_th' rowspan='2'>
				料金
			</th>
			<th class='dummy_th' >
				
			</th>
		</tr>
		<th class='first_discount' >
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
				<?php
				$this->_chk_list[$id]->view();
				echo $course->name; ?>
				</td>
				<?php
				$this->td($course->time_required.'分', 'value');
				$this->td('￥'.number_format($course->price), 'value');
				$price;
				if($course->first_discount == 0){
					$price = '-';
				}else{
					$price = '￥'. number_format($course->first_discount);
				}
				$this->td($price, 'value');
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