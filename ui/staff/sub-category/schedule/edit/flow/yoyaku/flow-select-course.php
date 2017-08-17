<?php
namespace ui\staff;
use business\entity\Staff;
use ui\frame\ManageFrameContext;
use business\entity\Schedule;
use ui\staff\ScheduleBase;

class FlowSelectCourse extends FlowYoyakuBase
{
    private $_menu_list = [];
	private $_chk_list = [];
	private $_id_list = [];

    protected function init_inner()
    {
		$fc = FlowYoyakuContext::get_instance();
       
    }

	private function param_list()
	{
		$fc = FlowYoyakuContext::get_instance();
		return [
            $fc->course_id_list
        ];
	}

    public function clear_temp_data()
    {
		foreach($this->param_list() as $p){    
			if(!isset($_POST[$p->get_key()])){
				$p->clear();
			}
        }
    }

    protected function input_check_inner()
    {
        return count(array_filter($this->param_list(), function($p){
            return !$p->is_set();
        })) == 0;
    }

	private function td($value, $class_name='')
	{
		?>
		<td class='<?php echo $class_name; ?>' >
		<?php echo $value; ?>
		</td>
		<?php
	}

    protected function enable_save_inner() : bool
    {
        $fc = FlowYoyakuContext::get_instance();
        return $fc->customer_id->is_set();
    }

    protected function view_inner()
    {
		$fc = FlowYoyakuContext::get_instance();
 		$this->_menu_list = \business\facade\get_menu_course_in_group();
		foreach($this->_menu_list as $key => $course_list)
		{
			foreach($course_list as $c)
			{
				$add_atribute = [];
				$row_id = "row_".$c->id;
				$onclick = sprintf ( 'on_check_menu("%s", "%d")', $row_id, $c->id);
				$add_atribute['onclick'] = $onclick;
				$add_atribute['id'] = $c->id;
				$style = '';
				if($fc->course_id_list->is_set()){
					foreach($fc->course_id_list->get_value() as $id)
					{
						if($c->id == $id){
							$add_atribute['checked'] = '';
						}
					}
				}
				$this->_id_list[] = $c->id;
				$input_name = FlowYoyakuContext::get_instance()->course_id_list->get_key().'[]';
				$this->_chk_list[$c->id] = new \ui\util\InputBase('checkbox', $input_name, $c->id, $style, $add_atribute);
			}
		}
?>
        <div class='line'>
        <h2>コースの選択</h2>
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
				$th_style = 'course_row';
	
				if($fc->course_id_list->is_set())
				{
					foreach($fc->course_id_list->get_value() as $selected_id)
					{
							if($course->id == $selected_id){
							$th_style = 'course_row selected';
						}
					}
				}
		
				?>
				<tr class='<?php echo $th_style; ?>' id = '<?php echo $row_id; ?>'>
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
		<div>
	<?php
    }

}

?>