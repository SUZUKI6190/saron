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
	public abstract function get_from_date();
	public abstract function get_to_date();
}

class MonthlyForm extends DateInputForm
{
	public function view_form()
	{
		$from_day =  date("Y-m", strtotime("-3 year"));
		$now_day = date('Y-m');
		?>
		<input type='month' name='from_date'  min='<?php echo $from_day;?>' max='<?php echo $now_day ?>'>
		から
		<input type='month' name='to_date'  min='<?php echo $from_day;?>' max='<?php echo $now_day ?>'>
		<?php
	}
	public function get_from_date()
	{
		return $_POST['from_date'];
	}
	public function get_to_date()
	{
		return $_POST['to_date'];
	}
}


class DaylyForm extends DateInputForm
{
	public function view_form()
	{
		$from_day =  date("Y-m-d", strtotime("-3 year"));
		$now_day = date('Y-m-d');
		?>
		<input type='date' name='from_date'  min='<?php echo $from_day;?>' max='<?php echo $now_day ?>'>
		から
		<input type='date' name='to_date'  min='<?php echo $from_day;?>' max='<?php echo $now_day ?>'>
		<?php
	}
	public function get_from_date()
	{
		return $_POST['from_date'];
	}
	public function get_to_date()
	{
		return $_POST['to_date'];
	}
}

abstract class SalesSubBase extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	private $_chk_day, $_chk_month;
	const SepTypeName = 'sep_type';
	private $_date_form;
	private $_view_graph_button;

	protected abstract function create_graph_param(Sales $sales);

	public function get_sales_data()
	{
		$from = $this->get_from_date();
		$to = $this->get_to_date();
		return get_sales_byday($from, $to);
	}
	
	public function __construct()
	{
		$attribute = [];
		$attribute['onclick'] = 'SubmitOnClick("month_or_day")';
		
		if(!isset($_POST[SalesSubBase::SepTypeName])){
			$this->_date_form = new MonthlyForm();
		}else{
			if($_POST[SalesSubBase::SepTypeName] == 'day')
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
		if(!isset($_POST[SalesSubBase::SepTypeName]))
		{
			if($default)
			{
				echo 'checked';
			}
			return;
		}
		if($_POST[SalesSubBase::SepTypeName] == $name)
		{
			echo 'checked';
		}
	}
	
	public function view()
	{?>
		<form action='' method='post' id='<?php echo $this->_form_id; ?>'>
			<div class="input_form">
			<?php $this->_view_graph_button->view(); ?>
			<div class="line">
				<h2>表示を選択</h2>			
				<input type='radio' name='<?php echo SalesSubBase::SepTypeName ?>' value='month' onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked('month', true); ?> >月別
				<input type='radio' name='<?php echo SalesSubBase::SepTypeName ?>' value='day'  onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked('day'); ?> >日別
			</div>
			<div class="line">
				<h2>月別</h2>
				<?php
				$this->_date_form->view_form();
				?>
			</div>
			</div>
			<?php
			if($this->_view_graph_button->is_submit())
			{
				
			}
			?>
		</form>
	<?php

	}	
}
?>