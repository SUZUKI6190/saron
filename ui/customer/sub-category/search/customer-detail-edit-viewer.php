<?php
namespace ui\customer;
use business\entity\Customer;
use business\facade;
use ui\util\ConfirmSubmitButton;
use ui\util\SubmitButton;
require_once("customer-detail.php");
require_once('search-viewer.php');

class CustomerDetailEditViewer extends CustomerDetail implements SearchViewer
{
	private $_id;
	private $_delete_button;
	private $_update_button;

	public function __construct()
	{
		parent::__construct();
		$cc = CustomerContext::get_instance();
		$this->_id = $cc->Id;
		$this->_delete_button = new ConfirmSubmitButton("delete_cutomer", "このお客様情報を削除する", "", "削除してもよろしいですか？", "search_delete");
		$this->_update_button = new SubmitButton( CustomerDetail::$SavePostKey, "お客様情報を更新する", "");
	}

	public function init()
	{
		if($this->_update_button->is_submit())
		{
			$this->save();
		}
		
	}

	protected function create_header()
	{
		?>
			<div style="text-align:right;:">
			<?php
			$this->_update_button->view();
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

	public function create_customer_data()
	{
		$data = \business\facade\SelectCustomerById($this->_id);
		return $data;
	}
	
	protected function save_inner(Customer $data)
	{
		$data->id = $this->_id;
		\business\facade\UpdateCustomer($data);
	}
}

?>