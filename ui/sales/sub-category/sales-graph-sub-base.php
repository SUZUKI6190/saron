<?php
namespace ui\sales;
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\Sales;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;

abstract class DateInputForm
{
	public abstract function view_form();
	const FromDateName = "from_date";
	const ToDateName = "to_date";

	protected function view_input($type, $name, $min, $max, $value)
	{
		$input = sprintf("<input type='%s' name='%s' min='%s' max='%s' value='%s'>", $type, $name, $min, $max, $value);
		echo $input;
	}
	public function get_from_date() 
	{
		if(isset($_POST[self::FromDateName]))
		{
			return $_POST[self::FromDateName];
		}else{
			return "";
		}
	}
	public function get_to_date() 
	{
		if(isset($_POST[self::ToDateName])){
			return $_POST[self::ToDateName];
		}else{
			return "";
		}
	}
}

class MonthlyForm extends DateInputForm
{
	public function view_form()
	{
		$from_day =  date("Y-m", strtotime("-3 year"));
		$now_day = date('Y-m');
		$this->view_input('month', DateInputForm::FromDateName, $from_day, $now_day, $this->get_from_date());
		?>
		から
		<?php
		$this->view_input('month', DateInputForm::ToDateName, $from_day, $now_day, $this->get_to_date());
	}

}

class DaylyForm extends DateInputForm
{
	public function view_form()
	{
		$from_day =  date("Y-m-d", strtotime("-3 year"));
		$now_day = date('Y-m-d');
		$this->view_input('date', DateInputForm::FromDateName, $from_day, $now_day, $this->get_from_date());
		?>
		から	
		<?php
		$this->view_input('date', DateInputForm::ToDateName, $from_day, $now_day, $this->get_to_date());
	}
}

abstract class SalesGraphSubBase extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	private $_chk_day, $_chk_month;
	const SepTypeName = 'sep_type';
	const GraphDateName = 'graph_data';
	private $_date_form;
	private $_view_graph_button;

	private $_canvas_id = 'sales_graph';
	
	protected abstract function create_monthly_graph_param() : GraphData;
	protected abstract function create_dayly_graph_param(\DateTime $from_date, \DateTime $to_date) : GraphData;

	public function get_sales_data()
	{
		$from = $this->get_from_date();
		$to = $this->get_to_date();
		return get_sales_byday($from, $to);
	}
	
	public function init()
	{
		$attribute = [];
		$attribute['onclick'] = 'SubmitOnClick("month_or_day")';
		
		if(!isset($_POST[self::SepTypeName])){
			$this->_date_form = new MonthlyForm();
		}else{
			if($_POST[self::SepTypeName] == 'day')
			{
				$this->_date_form = new DaylyForm();
			}else{
				$this->_date_form = new MonthlyForm();
			}
		}
		$this->_view_graph_button = new SubmitButton('btn_graph', 'グラフを表示する', $this->_form_id);
	}

	private function set_checked($name, $default=false)
	{
		if(!isset($_POST[self::SepTypeName]))
		{
			if($default)
			{
				echo 'checked';
			}
			return;
		}
		if($_POST[self::SepTypeName] == $name)
		{
			echo 'checked';
		}
	}
	
	private function view_monthly()
	{

	}

	private function view_dayly()
	{?>
		<div class="line">
			<h2>月別</h2>
			<?php
			$this->_date_form->view_form();
			?>
		</div>
<?php
	}

	public function view()
	{
		$d = "?d=".(new \DateTime())->format("Ymdhis");	
?>
		<form action='<?php echo "$d" ?>' method='post' id='<?php echo $this->_form_id; ?>'>
			<div class="sales_wrap">
			<?php $this->_view_graph_button->view(); ?>
			<div class="line">
				<h2>表示を選択</h2>			
				<input type='radio' name='<?php echo self::SepTypeName ?>' value='month' onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked('month', true); ?> >月別
				<input type='radio' name='<?php echo self::SepTypeName ?>' value='day'  onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked('day'); ?> >日別
			</div>
			<?php
			if(isset($_POST[self::SepTypeName])){
				if($_POST[self::SepTypeName] == 'day'){
					$this->view_dayly();
				}else{
					$this->view_monthly();
				}
			}
			if($this->_view_graph_button->is_submit()){

				$script = sprintf('view_graph("%s", "%s");', $this->_canvas_id, self::GraphDateName);
				$fd = new \DateTime($this->_date_form->get_from_date());
				$td = new \DateTime($this->_date_form->get_to_date());
				$graph_data = $this->create_monthly_graph_param();
				$graph_data_json = $graph_data->serialize_json();
			?>
				<div class='sales_graph_area'>
					<canvas id='<?php echo $this->_canvas_id; ?>' class='sales_graph'></canvas>
				</div>
				<input type="hidden" id="<?php echo self::GraphDateName; ?>" value='<?php echo $graph_data_json; ?>'' >
				<script>
					<?php echo $script; ?>
				</script>
			<?php
			}
			?>
			</div>
		</form>

	<?php

	}
}
?>