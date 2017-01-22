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
		yield $this->_customerData->sex;
		yield $this->_customerData->old;
		yield $this->_customerData->birthday;
		yield $this->_customerData->last_visit_date;
		yield $this->_customerData->phone_number;

		$detail_url = $this->_controlContext->GetCustomerUrl()."/detail/edit/".$this->_customerData->id;
		echo  $detail_url;
		yield "<a href='$detail_url' >詳細はこちら</a>";
	}
}

function create_customer_view(ControlContext $c, $strWhere)
{
	$tableGenerator = new ui\TableGenerator();
	$data = [];
	foreach(\business\facade\GetCustomers($strWhere) as $customerData)
	{
		array_push($data, new CustomerTableData($customerData, $c));
	}
	
	$tableGenerator->DataSource = $data;
	$tableGenerator->HeaderDataSource = CustomerTableData::GetHeader();
	$tableGenerator->GenerateTable();
}
?>