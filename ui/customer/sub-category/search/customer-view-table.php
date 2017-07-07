<?php
namespace ui\customer;
use ui;
use ui\HeaderData;
use \business\entity\Customer;
require_once('itabledata.php');

class CustomerTableData implements ui\ITableData
{
	private $_customerData;
	public function __construct(Customer $custmerData)
	{
		$this->_customerData = $custmerData;
	}

	public static function GetHeader()
	{
		return [
			new HeaderData("氏名(漢字)", "header_kanji",
			function($d1, $d2) {
				$name1 = $d1->_customerData->name_kanji.$d1;
				$name2 = $d2->_customerData->name_kanji.$d2;
				return $name1 <=> $name2;
			}),
			new HeaderData("氏名(カナ)", "header_kana",
			function($d1, $d2) {
				$name1 = $d1->_customerData->name_kana;
				$name2 = $d2->_customerData->name_kana;
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
		yield $this->_customerData->name_kanji;
		yield $this->_customerData->name_kana;
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
		$cc = CustomerContext::get_instance();
		
		$detail_url = $cc->get_customer_url()."/search/detail/".$this->_customerData->id;

		yield "<a href='$detail_url' >詳細はこちら</a>";
	}
}

?>