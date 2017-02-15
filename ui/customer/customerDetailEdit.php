<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
use ui\util\ConfirmSubmitButton;
use ui\util\SubmitButton;
require_once("customerdetail.php");
class CustomerDetailEdit extends CustomerDetail
{
	private $_id;
	private $_delete_button;
	private $_update_button;
	public function __construct($id)
	{
		parent::__construct();
		$this->_id = $id;
		$this->_delete_button = new ConfirmSubmitButton("delete_cutomer", "このお客様情報を削除する", "", "削除してもよろしいですか？", "search_delete");
		$this->_update_button = new SubmitButton( CustomerDetail::$SavePostKey, "お客様情報を更新する", "");
	}
	public function CreateHeader()
	{
		?>
			<div style="text-align:right;:">
				<?php
				$this->_update_button->view();
				?>
			
	
		
			<?php
			$this->_delete_button->view();
			?>
			</div>		
		
		<?php
	}
	protected function on_pre_view()
	{
		if($this->_delete_button->is_submit())
		{
			\business\facade\delete_customer_byid($this->_id);
			echo "削除完了しました。";
			exit;
		}
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