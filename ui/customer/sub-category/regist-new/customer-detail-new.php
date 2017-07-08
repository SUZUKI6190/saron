<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
require_once(dirname(__FILE__)."/../customer-detail.php");

class CustomerDetailNew extends CustomerDetail
{
	protected function create_header()
	{
		?>
			<div class="new_regist centering">
				<input type='submit' class='manage_button' name='<?php echo CustomerDetail::$SavePostKey; ?>' value='お客様情報を新しく登録する'>
			</div>
		<?php
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