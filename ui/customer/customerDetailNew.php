<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
require_once("customerdetail.php");
class CustomerDetailNew extends CustomerDetail
{
	public function CreateHeader()
	{
		?>
			<div style="text-align:right;">
				<input type="button" value="お客様情報を新しく登録する" />
			</div>
		<?php
	}
	
	public function CreateCustomerData()
	{
		return  \business\entity\Customer::CreateEmptyObject();
	}
	
	public function SaveInner(Customer $data)
	{
		InsertCustomer($data);
	}
}
?>