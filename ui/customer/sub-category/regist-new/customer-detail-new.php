<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
require_once(dirname(__FILE__)."/../customer-detail.php");

class CustomerDetailNew extends CustomerDetail
{
	const UpdateBtnName = "UpdateBtn";
	protected function create_header()
	{
		?>
			<div class="new_regist centering">
				<input type='submit' class='manage_button' name='<?php echo self::UpdateBtnName; ?>' value='お客様情報を新しく登録する'>
			</div>
		<?php
	}

	private function is_save()
	{
		return isset($_POST[self::UpdateBtnName]);
	}

	public function init()
	{
		if($this->is_save())
		{
			$this->save();
		}
	}

	public function create_customer_data()
	{
		return  \business\entity\Customer::CreateEmptyObject();
	}
	
	protected function save_inner(Customer $data)
	{
		\business\facade\InsertCustomer($data);
	}
	
}
?>