<?php
	class Customer implements ITableData{
		public $id;
		public $tanto_id;
		public $name_kanji = "test1";
		public $name_kana = "test1";
		public $sex;
		public $old;
		public $birthday;
		public $last_visit_date;
		public $phone_number;
		public $address;
		public $occupation;
		public $number_of_visit;
		public $staff;
		public $email;
		public $enable_dm;
		public $next_visit_reservation_date;
		public $reservation_route;
		public $remarks;
		
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
			yield $this->name_kanji;
			yield $this->name_kana;
			yield $this->sex;
			yield $this->old;
			yield $this->birthday;
			yield $this->last_visit_date;
			yield $this->phone_number;
			$detail_url = get_bloginfo('wpurl')."/customer_detail?id=".$this->id;
			yield "<a href='" . $detail_url . "' >詳細はこちら</a>";
		}
	}
?>