<?php
namespace ui\sales;
require_once('sales-graph-sub-base.php');
require_once('graph-data.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\ReservedCourse;
use \business\entity\YoyakuRegistration;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class SumNumDataCalculator extends DataCalculator
{
	private $_sum = 0;
	public function catch_reservedcourse(ReservedCourse $y)
	{
		
	}
	public function catch_registration(YoyakuRegistration $y)
	{
		$this->_sum += 1;
	}
	public function get_data()
	{
		return $this->_sum;
	}
}

class NumMonthlyForm extends MonthlyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumNumDataCalculator();
	}

}

class NumDaylyForm extends DaylyForm
{
	protected function create_calculator(): DataCalculator
	{
		return new SumNumDataCalculator();
	}
}




class SalesNumSub extends SalesGraphSubBase
{
	const CustomerTypeName = "CustomerType";
	const NewCustomeKey = "NewCustomer";
	const RepeaterCustomeKey = "RepeaterCustomer";
	
	protected function create_monthly_form() : MonthlyForm
	{
		return new NumMonthlyForm();
	}

	protected  function create_dayly_form() : DaylyForm
	{
		return new NumDaylyForm();
	}

	private function set_checked($name, $default=false)
	{
		if(!isset($_POST[self::CustomerTypeName]))
		{
			if($default)
			{
				echo 'checked';
			}
			return;
		}
		if($_POST[self::CustomerTypeName] == $name)
		{
			echo 'checked';
		}
	}

	protected function add_view()
	{
		?>
		<div class="line">
			<h2>種類を選択</h2>			
			<input type='radio' name='<?php echo self::CustomerTypeName ?>' value='<?php echo self::NewCustomeKey; ?>' onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked(self::NewCustomeKey, true); ?> >新規
			<input type='radio' name='<?php echo self::CustomerTypeName ?>' value='<?php echo self::RepeaterCustomeKey; ?>'  onclick='SubmitOnClick("<?php echo $this->_form_id; ?>")' <?php $this->set_checked(self::RepeaterCustomeKey); ?> >リピーター
		</div>

		<?php
	}


	public function get_name()
	{
		return "numberof";
	}
	
	public function get_title_name()
	{
		return "来店客数";
	}
	
}
?>