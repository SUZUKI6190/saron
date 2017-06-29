<?php
namespace ui\customer;
use business\entity\Customer;
use ui\util;
require_once(dirname(__FILE__)."/../staff.php");
require_once(dirname(__FILE__)."/../util/control-util.php");
require_once("customer-detail-item-list.php");

abstract class DetailItem
{
	protected $_customer_data;
	public function __construct(Customer $cd)
	{
		$this->_customer_data = $cd;
	}
	public abstract function view();
	public abstract function get_name();
	public abstract function save();

	public function input_check()
	{
		return true;
	}
	public function get_err_msg()
	{
		return "";
	}
	
	protected function required_text()
	{
		return "<span style='color:red';>※入力必須</span>";
	}

	protected function CreateOprionValue($text, $value, $selectedValue)
	{	
		if($value == $selectedValue){
			echo "<option value='$value' selected>$text</option>";
		}else{
			echo "<option value='$value'>$text</option>";
		}
		echo "\n";
	}
	
	protected function GetDatePostData($key)
	{
		return date('Ymd',strtotime($_POST[$key]));
	}
	
	protected function ConvertInputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
	}

}

abstract class CustomerDetail
{
	private $_view_staff;
	private $_birth;
	private $_last_visit_date;
	private $_next_visit_reservation_date;
	public function __construct()
	{
		$this->_view_staff = new \ui\ViewStaff("staff");
		$this->_birth = new \ui\util\view_date_input("birth");
		$this->_last_visit_date = new \ui\util\view_date_input("last_visit_date");
		$this->_next_visit_reservation_date= new \ui\util\view_date_input("next_visit_reservation_date");
	}
	public function View()
	{
		$data = $this->CreateCustomerData();
		$this->CreateForm($data);
	}

	private function ConvertInputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
	}

	public function Save()
	{
		$data = new Customer();
		$item_list = $this->get_item_list($data);
		
		$result = array_filter($item_list, function($item){
			return !$item->input_check();
		});
		
		if(count($result) > 0)
		{
			$this->View();
			return;
		}
		
		foreach($item_list as $item)
		{
			$item->save();
		}
		
		$this->SaveInner($data);

		?>

		<div class="regist_finish">
			<span>登録が完了しました。</span>
		</div>

		<?php
	}

	protected static $SavePostKey = 'save';

	public function IsSavePost()
	{
		if(empty($_POST[CustomerDetail::$SavePostKey])){
			return false;
		}else{
			return true;
		}
	}
	
	
	protected abstract function CreateHeader();
	public abstract function CreateCustomerData();
	protected function get_item_list(Customer $data)
	{
		return create_item_list($data);
	}
	protected abstract function SaveInner(Customer $data);
	
	private function required_text()
	{
		?>
		<span style="color:red;">※入力必須</span>
		<?php
	}
	
	protected function on_pre_view()
	{
	}
	
	protected function CreateForm(Customer $data)
	{
		$this->on_pre_view();
	?>

	<form method="POST">
		<div class="wrap">
			<?php
			$this->CreateHeader();
			?>
			<div class="input_form detail">
				<div class="area">
					<?php
					$view_func;
					if($this->IsSavePost()){
						$view_func = function($item)
						{
							?>
							<div class="line">
								<h2>
									<?php echo $item->get_name(); ?>:
								</h2>
								<?php 
								if(!$item->input_check())
								{
									?>
									<div class="detail_input_error">
										<span><?php echo $item->get_err_msg(); ?></span>
									</div>
									<?php 
								}
								echo $item->view();
								?>
							</div>
							<?php
						};
					}else{
						$view_func = function($item)
						{
							?>
							<div class="line">
								<h2>
									<?php echo $item->get_name(); ?>:
								</h2>
								<?php 
								echo $item->view();
								?>
							</div>
							<?php
						};
					}
					foreach($this->get_item_list($data) as $item)
					{
						$view_func($item);
					}
					?>
	
				</div>
			</div>
		</div>
	</form>
		<?php
	}
}
?>