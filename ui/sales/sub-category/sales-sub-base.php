<?php
namespace ui\sales;
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\Sales;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;

class FFFFMMInputform
{
	private $_name;
	public function __construct($name)
	{
		$this->_name = $name;
	}
	
	public function view()
	{?>

		<select name='<?php echo $name.'_month'; ?>'>
		<?php
		$now_day = date('Y');
		$counter = 0;
		while($counter < 3)
		{
			$view_year = $now_day - $counter;
		?>
			<option value='<?php echo $view_year; ?>'><?php echo $view_year; ?></option>
		<?php
			$counter++;
		}
		?>
		</select>年
		<select name='<?php echo $name.'_year'; ?>'>
		<?php
		for($i = 1 ; $i < 13 ; $i++)
		{?>
			<option value='<?php echo $i; ?>'><?php echo $i; ?></option>
		<?php
		}
		?>
		</select>月
	<?php
	}
}

abstract class SalesSubBase extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	private $_period_form;
	
	protected abstract function create_graph_param(Sales $sales);
	
	public function __construct()
	{
		
		$this->_period_form = new FFFFMMInputform('from');
	}

	public function view()
	{?>
		<div class="input_form">
			<div class="line">
				<h2>月別</h2>
				<?php $this->_period_form->view(); ?>
				<span class='discript'>
				</span>
				
			</div>
		</div>
	<?php
	}	
}
?>