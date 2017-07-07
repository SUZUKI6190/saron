<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
require_once("customer-detail.php");

class CustomerDetailNewViewer extends CustomerDetail
{
	public function CreateHeader()
	{
		?>
			<div class="new_regist centering">
				<input type='submit' class='manage_button' name='<?php echo CustomerDetail::$SavePostKey; ?>' value='お客様情報を新しく登録する'>
			</div>
		<?php
	}
	
	public function CreateCustomerData()
	{
		return  \business\entity\Customer::CreateEmptyObject();
	}
	
	public function SaveInner(Customer $data)
	{
		\business\facade\InsertCustomer($data);
	}
	
}
?>