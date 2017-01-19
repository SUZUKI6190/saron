<?php
namespace ui\customer;
use business\entity\Customer;

abstract class CustomerDetail
{
	public function View()
	{
		$data = $this->CreateCustomerData();
		$this->CreateForm($data);
	}

	private function GetDatePostData($key)
	{
		echo date('Ymd',strtotime($_POST[$key]));
		return date('Ymd',strtotime($_POST[$key]));
	}
	
	public function Save()
	{
		$data = new Customer();
		$data->name_kanji_last = $_POST["name_kanji_last"];
		$data->name_kanji_first = $_POST["name_kanji_first"];
		$data->name_kana_last = $_POST["name_kana_last"];
		$data->name_kana_first = $_POST["name_kana_first"];
		$data->sex  = $_POST["sex"];
		$data->old = $_POST["old"];
		$data->birthday = $this->GetDatePostData("birthday");
		$data->last_visit_date = $this->GetDatePostData("last_visit_date");
		$data->phone_number = $_POST["phone_number"];
		$data->address = $_POST["address"];
		$data->occupation = $_POST["occupation"];
		$data->number_of_visit = $_POST["number_of_visit"];
		$data->staff= $_POST["staff"];
		$data->email = $_POST["email"];
		$data->enable_dm = $_POST["enable_dm"];
		$data->next_visit_reservation_date = $this->GetDatePostData("next_visit_reservation_date");
		$data->eservation_route = $_POST["eservation_route"];
		$data->remarks = $_POST["remarks"];
		
		print_r($data);
		$this->SaveInner($data);
	}

	protected static $SavePostKey = 'name_kanji_last';
	
	public function IsSavePost()
	{
		//print_r($_POST);
		$postdata = $_POST[CustomerDetail::$SavePostKey];
		return  $postdata != "";
	}
	
	protected abstract function CreateHeader();
	public abstract function CreateCustomerData();
	protected abstract function SaveInner(Customer $data);
	protected function CreateOprionValue($text, $value, $selectedValue)
	{	
		if($value == $selectedValue){
			echo "<option value=''$value' selected>$text</option>";
		}else{
			echo "<option value=''$value'>$text</option>";
		}
		echo "\n";
	}
	
	protected function CreateForm(Customer $data)
	{
		?>
			<div class="detail">
				<form method="POST" action=".">
				<?php
				$this->CreateHeader();
				?>
				<div class="area">
					<div class="line">
						<div class="name">
							氏名(漢字)：
						</div>
						<div>
							<input name="name_kanji_last" type="text" value='<?php echo $data->name_kanji_last; ?>' />
							<input name="name_kanji_first" type="text" value='<?php echo $data->name_kanji_first; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							氏名(カナ)：
						</div>
						<div>
							<input name="name_kana_first" type="text" value='<?php echo $data->name_kana_last; ?>' />
							<input name="name_kana_last" type="text" value='<?php echo $data->name_kana_first; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							電話番号：
						</div>
						<div>
							<input name="phone_number" type="text" value='<?php echo $data->phone_number; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							E-mail：
						</div>
						<div>
							<input name="email" type="text" value='<?php echo $data->email; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							性別：
						</div>
						<div>
							<select name="sex" id="sex">
								<?php
									$this->CreateOprionValue("", "", $this->sex);
									$this->CreateOprionValue("女性", "F", $this->sex);
									$this->CreateOprionValue("男性", "M", $this->sex);
								?>
							</select>
					   </div>
					</div>
					<div class="line">
						<div class="name">
							年齢：
						</div>
						<div>
							<input name='old' type="text" value='<?php echo $data->old; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							誕生日：
						</div>
						<div>
							<input name='birthday' type="date" value='<?php echo $data->birthday; ?>' />
						</div>
					</div>
				</div>
				<div class="area">
					<div class="line">
						<div class="name">
							住所：
						</div>
						<div>
							<input type="text" name='address' value='<?php echo $data->addres; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							職業：
						</div>
						<div>
							<input name='occupation' type="text" value='<?php echo $data->occupation; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							来店回数：
						</div>
						<div>
							<input name='number_of_visit' type="text" value='<?php echo $data->number_of_visit; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							スタッフ：
						</div>
						<div>
							<input name='staff' type="text" value='<?php echo $data->tant_id; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							最終来店日：
						</div>
						<div>
							<input name='last_visit_date' type="date" value='<?php echo $data->last_visit_date; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							次回来店予約日：
						</div>
						<div>
							<input name='next_visit_reservation_date' type="date" value='<?php echo $data->next_visit_reservation_date; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							予約経路：
						</div>
						<div>
							<input name='reservation_route' type="date" value='<?php echo $data->reservation_route; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							DM不可：
						</div>
						<div>
							<input type="checkbox" name="enable_dm" value='1' checked="checked" />
						</div>
					</div>
					<div class="line">
						<div class="name">
							備考：
						</div>
						<div>
							<input name='remarks' type="text" value='<?php echo $data->remarks; ?>' />
						</div>
					</div>
				</div>
				</form>
			</div>

		<?php
	}
}
?>