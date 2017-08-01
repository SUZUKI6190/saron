<?php
namespace ui\staff;
use \business\entity\Staff;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\util\InputControll;
use \ui\frame\Result;
use ui\frame\ManageFrameContext;
use \business\entity\StaffSchedule;
use \business\entity\Schedule;
use ui\staff\ScheduleBase;

class ScheduleCourseSelect extends ScheduleBase
{
	private $_menu_list = [];
	private $_chk_list = [];
	private $_id_list = [];

    protected function init_inner()
    {
        $this->_menu_list = \business\facade\get_menu_course_in_group();
		
		foreach($menu_list as $key => $course_list)
		{
			foreach($course_list as $c)
			{
				$add_atribute = [];
				$row_id = "row_".$c->id;
				$onclick = sprintf ( 'on_check_menu("%s", "%d")', $row_id, $c->id);
				$add_atribute['onclick'] = $onclick;
				$add_atribute['id'] = $c->id;
				$this->_id_list[] = $c->id;
				$this->_chk_list[$c->id] =  new InputBase('checkbox', 'course_id[]', $c->id, '', $add_atribute);
			}
		}
    }

    protected function view_inner()
    {
		?>
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
		foreach($this->_menu_list as $key => $menu_course_list)
		{
			?>
			<tr class='menu_row'>
			<?php		
			$this->td($key);
			$this->td('');
			$this->td('');
			$this->td('');
			?>
			</tr>
			<?php
			foreach($menu_course_list as $course)
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