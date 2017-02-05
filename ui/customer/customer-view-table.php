<?php
namespace ui\customer;
use ui;
use \business\entity\Customer;
require_once(dirname(__FILE__).'/../itabledata.php');
class CustomerTableData implements ui\ITableData
{
	private $_customerData;
	private $_controlContext;
	public function __construct(Customer $custmerData, ControlContext $c)
	{
		$this->_customerData = $custmerData;
		$this->_controlContext = $c;
	}

	public static function GetHeader()
	{
		return [
			"氏名(漢字)",
			"氏名(カナ)",
			"性別",
			"年齢",
			"誕生日",
			"最終来店日",
			"電話番号",
			""
		];
	}
	
	public function HeaderGenerator()
	{
		yield "氏名(漢字)";
		yield "氏名(カナ)";
		yield "性別";
		yield "年齢";
		yield "誕生日";
		yield "最終来店日";
		yield "電話番号";
		
	}

	public function RowGenerator()
	{
		yield $this->_customerData->name_kanji_last.$this->_customerData->name_kanji_first;
		yield $this->_customerData->name_kana_last.$this->_customerData->name_kana_first;
		$sex_name = "";
		if($this->_customerData->sex == 'M'){
			$sex_name = "男性";
		}elseif($this->_customerData->sex == 'F'){
			$sex_name = "女性";
		}
		yield $sex_name;
		yield $this->_customerData->old;
		yield date('Y/m/d',strtotime($this->_customerData->birthday));
		yield date('Y/m/d',strtotime($this->_customerData->last_visit_date));
		yield $this->_customerData->phone_number;

		$detail_url = $this->_controlContext->GetCustomerUrl()."/search/detail/".$this->_customerData->id;

		yield "<a href='$detail_url' >詳細はこちら</a>";
	}
}

function search_by_input($strWhere)
{	
	return \business\facade\GetCustomers($strWhere) ;
}

function search_by_hidden($hidden_name)
{
	$csv = str_getcsv($_POST[$hidden_name]);
	$ret = [];
	foreach($csv as $id)
	{
		$ret[] = \business\facade\SelectCustomerById($id);
	}
	
	return $ret;
}

function create_customer_view(ControlContext $c, $strWhere)
{
	$name_value_hidden = "key_value_list";
	$name_delete_submit = "delete";
	$name_export_submit = "csv_export";
	
	$tableGenerator = new ui\TableGenerator();
	$data = [];
	$key_hidden ="";
	$customer_data_list;
	if($_POST[$name_export_submit]){
		$customer_data_list = search_by_hidden($name_value_hidden);
	}else{
		$customer_data_list = search_by_input($strWhere);
	}
	foreach($customer_data_list as $customerData)
	{
		$key_hidden = $key_hidden.$customerData->id.",";
		array_push($data, new CustomerTableData($customerData, $c));
	}
	
	$key_hidden = rtrim($key_hidden, ',');
	
	?>
	<form method="post" action="./">
	<?php
	echo "<input type='hidden' name='$name_value_hidden' value='$key_hidden' />";
	\ui\util\submit_button('検索結果をCSVで出力する', $name_export_submit);
	\ui\util\submit_button('検索結果を削除する', $name_delete_submit);
	$tableGenerator->DataSource = $data;
	$tableGenerator->HeaderDataSource = CustomerTableData::GetHeader();
	$tableGenerator->GenerateTable();
	?>
	</form>
	<?php
}
?>