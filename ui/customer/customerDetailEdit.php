<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
require_once("customerdetail.php");
class CustomerDetailEdit extends CustomerDetail
{
	private $_id;
	public function __construct($id)
	{
		$this->_id = $id;
	}
	public function CreateHeader()
	{
		?>
			<div style="text-align:right;">
				<input type='submit' name='save' value='お客様情報を更新する' />
			</div>
		<?php
	}
	
	public function CreateCustomerData()
	{
		$data = \business\facade\SelectCustomerById($this->_id);
		return $data;
	}
	
	public function SaveInner(Customer $data)
	{
		$data->id = $this->_id;
		\business\facade\UpdateCustomer($data);
	}
}
?>