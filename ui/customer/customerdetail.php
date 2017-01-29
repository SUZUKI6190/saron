<?php
namespace ui\customer;
use business\entity\Customer;
use ui\util;
require_once(dirname(__FILE__)."/../staff.php");
require_once(dirname(__FILE__)."/../util/control-util.php");
abstract class CustomerDetail
{
	private $_view_staff;
	private $_birth;
	private $_last_visit_date;
	private $_next_visit_reservation_date;
	public function __construct()
	{
		$this->_view_staff = new \ui\ViewStaff("staff");
		$this->_birth = new \ui\util\view_date_input("birth");
		$this->_last_visit_date = new \ui\util\view_date_input("last_visit_date");
		$this->_next_visit_reservation_date= new \ui\util\view_date_input("next_visit_reservation_date");
	}
	public function View()
	{
		$data = $this->CreateCustomerData();
		$this->CreateForm($data);
	}

	private function GetDatePostData($key)
	{
		return date('Ymd',strtotime($_POST[$key]));
	}
	
	private function ConvertInputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
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
		$data->birthday = $this->_birth->get_selected_value();
		$data->last_visit_date = $this->_last_visit_date->get_selected_value();
		$data->phone_number = $_POST["phone_number"];
		$data->address = $_POST["address"];
		$data->occupation = $_POST["occupation"];
		$data->number_of_visit = $_POST["number_of_visit"];
		$data->tanto_id = $this->_view_staff->get_value();
		$data->email = $_POST["email"];
		if($_POST["enable_dm"] =="")
		{
			$data->enable_dm = 0;
		}else{
			$data->enable_dm = 1;
		}
		$data->next_visit_reservation_date = $this->GetDatePostData("next_visit_reservation_date");
		$data->reservation_route = $_POST["reservation_route"];
		$data->remarks = $_POST["remarks"];
		$this->SaveInner($data);

		?>

		<div class="regist_finish">
			<span>登録が完了しました。</span>
		</div>

		<?php
	}

	protected static $SavePostKey = 'name_kanji_last';

	public function IsSavePost()
	{
		if(empty($_POST[CustomerDetail::$SavePostKey])){
			return false;
		}else{
			return true;
		}
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
		
	<form method="POST" action=".">
		<div class="wrap">
			<?php
			$this->CreateHeader();
			?>
			<div class="detail">

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
							<input name="name_kana_last" type="text" value='<?php echo $data->name_kana_last; ?>' />
							<input name="name_kana_first" type="text" value='<?php echo $data->name_kana_first; ?>' />
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
									$this->CreateOprionValue("", "None", $data->sex);
									$this->CreateOprionValue("女性", "F", $data->sex);
									$this->CreateOprionValue("男性", "M", $data->sex);
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
							<?php
								$this->_birth->view($data->birthday);
							?>
						</div>
					</div>
				</div>
				<div class="area">
					<div class="line">
						<div class="name">
							住所：
						</div>
						<div>
							<input type="text" name='address' value='<?php echo $data->address; ?>' />
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
							<?php
							$this->_view_staff->view_staff_select();
							?>
						</div>
					</div>
					<div class="line">
						<div class="name">
							最終来店日：
						</div>
						<div>
							<?php
							$this->_last_visit_date->view($data->last_visit_date);
							?>
						</div>
					</div>
					<div class="line">
						<div class="name">
							次回来店予約日：
						</div>
						<div>
							<?php
							$this->_next_visit_reservation_date->view($data->next_visit_reservation_date);
							?>
						</div>
					</div>
					<div class="line">
						<div class="name">
							予約経路：
						</div>
						<div>
							<input name='reservation_route' type="text" value='<?php echo $data->reservation_route; ?>' />
						</div>
					</div>
					<div class="line">
						<div class="name">
							DM不可：
						</div>
						<div>
							<?php
							
								if($data->enable_dm == 0)
								{
								?>
								<input type="checkbox" name="enable_dm" value='enable_dm' />							
								<?php
								}else{
								?>
								<input type="checkbox" name="enable_dm" value='enable_dm' checked="checked" />						
								<?php
								}
						?>
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
			</div>
		</div>
		</form>
		<?php
	}
}
?>