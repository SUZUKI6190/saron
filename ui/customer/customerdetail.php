<?php
namespace ui\customer;
use business\entity\Customer;

abstract class CustomerDetail
{
	public function View()
	{
		$data = $this->CreateCustomerData();
		$this->CreateHeader();
		$this->CreateForm($data);
	}

	public function Save()
	{
		$data = new Customer();
		$data->name_kanji_last = _POST["name_kanji_last"];
		$this->SaveInner($data);
	}

	protected static $SavePostKey = 'save';
	
	public function IsSavePost()
	{
		return $_Post[$SavePostKey];
	}
	
	protected abstract function CreateHeader();
	public abstract function CreateCustomerData();
	protected abstract function SaveInner(Customer $data);
	protected function CreateOprionValue($text, $value, $selectedValue)
	{	
		if($value == $selectedValue){
			echo "<option value='$value' selected>$text</option>";
		}else{
			echo "<option value='$value'>$text</option>";
		}
		echo "\n";
	}
	
	protected function CreateForm(Customer $data)
	{
		?>
			<div class="detail">
				<div class="area">
					<div class="line">
						<div class="name">
							氏名(漢字)：
						</div>
						<div>
							<input name="name_kanji_last" type="text" value=<?php echo $data->name_kanji_last; ?> />
							<input name="name_kanji_first" type="text" value=<?php echo $data->name_kanji_first; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							氏名(カナ)：
						</div>
						<div>
							<input name="name_kana_first" type="text" value=<?php echo $data->name_kana_last; ?> />
							<input name="name_kana_last" type="text" value=<?php echo $data->name_kana_first; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							電話番号：
						</div>
						<div>
							<input name="phone_number" type="text" value=<?php echo $data->phone_number; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							E-mail：
						</div>
						<div>
							<input name="email" type="text" value=<?php echo $data->email; ?> />
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
							<input name='old' type="text" value=<?php echo $data->old; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							誕生日：
						</div>
						<div>
							<input name='birthday' type="date" value=<?php echo $data->birthday; ?> />
						</div>
					</div>
				</div>
				<div class="area">
					<div class="line">
						<div class="name">
							住所：
						</div>
						<div>
							<input type="text" />
						</div>
					</div>
					<div class="line">
						<div class="name">
							職業：
						</div>
						<div>
							<input name='occupation' type="text" value=<?php echo $data->occupation; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							電話番号：
						</div>
						<div>
							<input name='phone_number' type="text" value=<?php echo $data->phone_number; ?> />
						</div>
					</div>

					<div class="line">
						<div class="name">
							来店回数：
						</div>
						<div>
							<input name='number_of_visit' type="text" value=<?php echo $data->number_of_visit; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							スタッフ：
						</div>
						<div>
							<input name='staff' type="text" value=<?php echo $data->tant_id; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							最終来店日：
						</div>
						<div>
							<input name='last_visit_date' type="date" value=<?php echo $data->last_visit_date; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							次回来店予約日：
						</div>
						<div>
							<input name='next_visit_reservation_date' type="date" value=<?php echo $data->next_visit_reservation_date; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							予約経路：
						</div>
						<div>
							<input name='reservation_route' type="date" value=<?php echo $data->reservation_route; ?> />
						</div>
					</div>
					<div class="line">
						<div class="name">
							DM不可：
						</div>
						<div>
							<input type="checkbox" name="enable_dm" value="1" checked="checked" />
						</div>
					</div>
					<div class="line">
						<div class="name">
							備考：
						</div>
						<div>
							<input name='remarks' type="text" value=<?php echo $data->remarks; ?> />
						</div>
					</div>
				</div>
			</div>

		<?php
	}
}
?>