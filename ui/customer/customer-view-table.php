<?php
namespace ui\customer;
use ui;
use ui\HeaderData;
use \business\entity\Customer;
require_once(dirname(__FILE__).'/../itabledata.php');
require_once("customer-download.php");
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
			new HeaderData("氏名(漢字)", "header_kanji",
			function($d1, $d2) {
				$name1 = $d1->_customerData->name_kanji_last.$d1->_customerData->name_kanji_first;
				$name2 = $d2->_customerData->name_kanji_last.$d2->_customerData->name_kanji_first;
				return $name1 <=> $name2;
			}),
			new HeaderData("氏名(カナ)", "header_kana",
			function($d1, $d2) {
				$name1 = $d1->_customerData->name_kana_last.$d1->_customerData->name_kana_first;
				$name2 = $d2->_customerData->name_kana_last.$d2->_customerData->name_kana_first;
				return $name1 <=> $name2;
			}),
			new HeaderData("性別", "header_sex",
			function($d1, $d2) {
				return $d1->_customerData->sex <=> $d2->_customerData->sex;
			}),
			new HeaderData("年齢", "header_old",
			function($d1, $d2) {
				return $d1->_customerData->old <=> $d2->_customerData->old;
			}),
			new HeaderData("誕生日", "header_birth",
			function($d1, $d2) {
				return $d1->_customerData->birthday <=> $d2->_customerData->birthday;
			}),
			new HeaderData("最終来店日", "header_last_visit",
			function($d1, $d2) {
				return $d1->_customerData->last_visit_date <=> $d2->_customerData->last_visit_date;
			}),
			new HeaderData("電話番号", "header_tell",
			function($d1, $d2) {
				return $d1->_customerData->phone_number <=> $d2->_customerData->phone_number;
			}),
			new HeaderData("", "",function($d1, $d2) {
				return 0;
			}),
		];
	}

	private function get_date_value($value)
	{
		if(empty($value))
		{
			return "";
		}else{
			return date('Y/m/d',strtotime($value));
		}
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
		yield $this->get_date_value($this->_customerData->birthday);
		yield $this->get_date_value($this->_customerData->last_visit_date);
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
	$name_export_submit = "csv_export";
	
	$tableGenerator = new ui\TableGenerator(CustomerTableData::GetHeader());
	$data = [];
	$key_hidden ="";


	$customer_data_list;

	if($tableGenerator->is_sort_change()){
		$customer_data_list = search_by_hidden(CustomerDownload::CUSTOMER_ID_NAME);
	}else{
		$customer_data_list = search_by_input($strWhere);
	}

	foreach($customer_data_list as $customerData)
	{
		$key_hidden = $key_hidden.$customerData->id.",";
		array_push($data, new CustomerTableData($customerData, $c));
	}
	?>
	<div class ="search_menu">
	<form method="post" action="<?php echo $download_url; ?>" >
		<?php
		$key_hidden = rtrim($key_hidden, ',');
		$key = CustomerDownload::CUSTOMER_ID_NAME;
		echo "<input type='hidden' name='$key' value='$key_hidden' />";
		\ui\util\submit_button('検索結果をCSVで出力する', $name_export_submit);
		?>
	</form>
	</div>
	<?php
	$tableGenerator->DataSource = $data;
	if($tableGenerator->is_sort_change()){
		$tableGenerator->sort_table();
	}
	$tableGenerator->GenerateTable("mein_form");

	$mc = \ui\frame\ManageFrameContext::get_instance();
	$download_url = $mc->get_url()."/download"
	
?>

	<?php
}
?>