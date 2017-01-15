<?php
namespace ui;
use \business\entity\Customer;
class CustomerTableData implements ITableData
{
	private $_customerData;

	public function __construct(Customer $custmerData)
	{
		$this->_customerData = $custmerData;
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
		yield $this->_customerData->name_kanji;
		yield $this->_customerData->name_kana;
		yield $this->_customerData->sex;
		yield $this->_customerData->old;
		yield $this->_customerData->birthday;
		yield $this->_customerData->last_visit_date;
		yield $this->_customerData->phone_number;
		$detail_url = get_bloginfo('wpurl')."/customer_detail?id=".$this->_customerData->id;
		yield "<a href='" . $detail_url . "' >詳細はこちら</a>";
	}
}

function CreaterCustomerTable()
{
	$tableGenerator = new TableGenerator();
	$data = [];
	foreach(\business\facade\GetCustomerAll() as $customerData)
	{
		array_push($data, new CustomerTableData($customerData));
	}
	
	$tableGenerator->DataSource = $data;
	$tableGenerator->HeaderDataSource = CustomerTableData::GetHeader();
	$tableGenerator->GenerateTable();
}
?>