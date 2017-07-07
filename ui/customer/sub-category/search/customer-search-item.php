<?php
namespace ui\customer;
require_once('customer-view-table.php');
require_once('itabledata.php');

abstract class SearchItem
{
	public abstract function exist_criteria();
	public abstract function get_criteria_query();
	public abstract function view();
	protected function get_post($key)
	{
		return $_POST[$key];
	}
	
	protected function is_empty_post($key)
	{
		return empty($_POST[$key]);
	}
	
	protected function create_decparam($param)
	{
		$password = \business\entity\Customer::GetPassword();
		return "CONVERT(AES_DECRYPT($param, '$password') USING utf8)";
	}
	protected function create_decparam_unsigned($param)
	{
		$password = \business\entity\Customer::GetPassword();
		return "cast(CONVERT(AES_DECRYPT($param, '$password') USING utf8) as SIGNED)";
	}
}

class SearchitemRepeater
{
	private $_item_list;

	const ExportBtnName = "delete_btn";
	const DeleteBtnName = "csv_export";
	const SearchBtnName = "search_btn";

	public function __construct($item_list)
	{
		$this->_item_list = $item_list;
	}
	
	public function is_search() : bool
	{
		return isset($_POST[self::SearchBtnName]);
	}

	public function create_where_query()
	{
				
		if(count($this->_item_list) == 0)
		{
			return '';
		}

		
		$exits_list = array_filter($this->_item_list, function($item){
			return $item->exist_criteria();
		});
		
		if(count($exits_list) == 0)
		{
			return '';
		}

		$add = 'where ';
		$strWhere = "";

		foreach($exits_list as $item)
		{
			foreach($item->get_criteria_query() as $q)
			{
				$strWhere = $strWhere.$add.$q;
				$add = ' and ';
			}
		}
		
		return $strWhere;
	}

	public function view_search_result()
	{
		$cc = CustomerContext::get_instance();
		$newUrl = $cc->get_customer_url()."/detail/new/";
		$strWhere = $this->create_where_query();
		
		$tableGenerator = new \ui\TableGenerator(CustomerTableData::GetHeader());
		$data = [];
		$key_hidden ="";

		$customer_data_list;

		if($tableGenerator->is_sort_change()){
			$csv = str_getcsv($_POST[CustomerDownload::CUSTOMER_ID_NAME]);
			$customer_data_list = [];
			foreach($csv as $id)
			{
				$customer_data_list[] = \business\facade\SelectCustomerById($id);
			}
		}else{
			$customer_data_list = \business\facade\GetCustomers($strWhere);
		}

		foreach($customer_data_list as $customerData)
		{
			$key_hidden = $key_hidden.$customerData->id.",";
			array_push($data, new CustomerTableData($customerData));
		}
		
		?>
		<div class ="search_menu">
			<?php
			$key_hidden = rtrim($key_hidden, ',');
			$key = CustomerDownload::CUSTOMER_ID_NAME;
			echo "<input type='hidden' name='$key' value='$key_hidden' />";
			?>
			<button type='submit' name='<?php echo self::ExportBtnName ?>' class='manage_button'>検索結果をCSVで出力する</button>

		</div>
		<?php
		$tableGenerator->DataSource = $data;
		if($tableGenerator->is_sort_change()){
			$tableGenerator->sort_table();
		}
		$tableGenerator->GenerateTable("mein_form");
		echo "<input type='hidden' name='$key' value='$key_hidden'/>";
		?>	
		<?php
	}
	
	public function view_search_form()
	{

		?>
		<div class="wrap_search">
			<div class="search_button">
				<button class="manage_button" type='submit' name='<?php echo self::SearchBtnName; ?>'>検索する</button>
				<input class="manage_button" type="reset" value="検索条件をクリアする" />
			</div>
			<?php $this->repeat(); ?>
		</div>
		<?php
	}
	
	private function repeat(){
	
		?>
		<div class="input_form">
		<div class='area'>
		<?php
		foreach($this->_item_list as $item)
		{
			?>
				<div class='line'>
				<?php
				$item->view();
				?>
				</div>

			<?php
		}
		?>
		
		</div>
		</div>
		<?php
	}
}
?>