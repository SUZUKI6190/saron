<?php
namespace ui\customer;
use business\entity\Customer;
require_once("customerdetail.php");

class KanjiNameDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name="name_kanji" type="text" value='<?php echo $this->_customer_data->name_kanji; ?>' required />
		<?php
	}
	public function get_name():string
	{
		return "氏名(漢字)".$this->required_text();
	}
	public function input_check() : bool
	{
		if(empty($_POST["name_kanji"])){
			return false;
		}

		if(empty($_POST["name_kanji"])){
			return false;
		}

		return true;
	}
	public function get_err_msg() : string
	{
		return "氏名(漢字)が未入力です。";
	}
	public function save()
	{
		$this->_customer_data->name_kanji = $_POST["name_kanji"];
	}
}

class KanaNameDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name="name_kana" type="text" value='<?php echo  $this->_customer_data->name_kana; ?>' required/>
		<?php
	}
	public function get_name() : string
	{
		return 	"氏名(カナ)".$this->required_text();
	}
	public function input_check() : bool
	{
		return true;
	}
	public function get_err_msg() : string
	{
		return "";
	}
	public function save()
	{
		$this->_customer_data->name_kana = $_POST["name_kana"];
	}
}

class TellDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name="phone_number" type="tel" value='<?php echo $this->_customer_data->phone_number; ?>' />
		<?php
	}
	public function get_name() : string
	{
		return 	"電話番号";
	}
	
	public function save()
	{
		$this->_customer_data->phone_number = $_POST["phone_number"];
	}
}

class MailDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name="email" type="email" value='<?php echo $this->_customer_data->email; ?>' />
		<?php
	}
	public function get_name() : string
	{
		return 	"E-mail";
	}
	
	public function save()
	{
		$this->_customer_data->email = $_POST["email"];
	}
}

class SexDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<select name="sex" id="sex">
			<?php
				$this->CreateOprionValue("", "None", $this->_customer_data->sex);
				$this->CreateOprionValue("女性", "F", $this->_customer_data->sex);
				$this->CreateOprionValue("男性", "M", $this->_customer_data->sex);
			?>
		</select>	
		<?php
	}
	public function get_name() : string
	{
		return 	"性別";
	}
	
	public function save()
	{
		$this->_customer_data->sex  = $_POST["sex"];
	}
}

class OldDetailItem extends DetailItem
{
	public function view()
	{
		\ui\util\numeric_input("old", $this->_customer_data->old);		
	}
	public function get_name() : string
	{
		return 	"年齢";
	}
	
	public function save()
	{
		$this->_customer_data->old = $_POST["old"];
	}
}


class BirthDetailItem extends DetailItem
{
	private $_birth;
	public function __construct(Customer $cd)
	{
		 parent::__construct($cd);
		 $this->_birth = new \ui\util\view_date_input("birth");
	}
	public function view()
	{
		$this->_birth->view($this->_customer_data->birthday);	
	}
	public function get_name() : string
	{
		return 	"誕生日";
	}
	
	public function save()
	{
		$this->_customer_data->birthday = $this->_birth->get_selected_value();
	}
}

class AddressDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input type="text" name='address' value='<?php echo $this->_customer_data->address; ?>' />
		<?php
	}
	public function get_name() : string
	{
		return 	"住所";
	}
	
	public function save()
	{
		$this->_customer_data->address = $_POST["address"];
	}
}

class OccupationDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name='occupation' type="text" value='<?php echo $this->_customer_data->occupation; ?>' />
		<?php
	}
	public function get_name() : string
	{
		return 	"職業";
	}
	
	public function save()
	{
		$this->_customer_data->occupation = $_POST["occupation"];
	}
}

class NumberOfVisitDetailItem extends DetailItem
{
	public function view()
	{
		\ui\util\numeric_input("number_of_visit", $this->_customer_data->number_of_visit);
	}
	public function get_name() : string
	{
		return 	"来店回数";
	}
	
	public function save()
	{
		$this->_customer_data->number_of_visit = $_POST["number_of_visit"];
	}
}

class StaffDetailItem extends DetailItem
{
	private $_view_staff;
	public function __construct(Customer $cd)
	{
		 parent::__construct($cd);
		 $this->_view_staff = new \ui\ViewStaff("staff");
	}
	public function view()
	{
		$this->_view_staff->view_staff_select();
	}
	public function get_name() : string
	{
		return 	"スタッフ";
	}
	
	public function save()
	{
		$this->_customer_data->tanto_id = $this->_view_staff->get_value();
	}
}

class LastVisitDateDetailItem extends DetailItem
{
	private $_last_visit_date;
	public function __construct(Customer $cd)
	{
		 parent::__construct($cd);
		 $this->_last_visit_date = new \ui\util\view_date_input("last_visit_date");
	}
	public function view()
	{
		$this->_last_visit_date->view($this->_customer_data->last_visit_date);
	}
	public function get_name() : string
	{
		return 	"最終来店日";
	}
	
	public function save()
	{
		$this->_customer_data->last_visit_date = $this->_last_visit_date->get_selected_value();
	}
}

class NextVisitReservationDateDetailItem extends DetailItem
{
	private $_next_visit_reservation_date;
	public function __construct(Customer $cd)
	{
		 parent::__construct($cd);
		 $this->_next_visit_reservation_date= new \ui\util\view_date_input("next_visit_reservation_date");
	}
	public function view()
	{
		$this->_next_visit_reservation_date->view($this->_customer_data->next_visit_reservation_date);
	}
	public function get_name() : string
	{
		return 	"次回来店予約日";
	}
	
	public function save()
	{
		$this->_customer_data->next_visit_reservation_date = $this->_next_visit_reservation_date->get_selected_value();
	}
}

class ReservationRouteDetailItem extends DetailItem
{
	private $_reservation_route;
	public function __construct(Customer $cd)
	{
		parent::__construct($cd);
		$this->_reservation_route = new \ui\util\RouteSelect();
		$this->_reservation_route->set_name("reservation_route");
		$this->_reservation_route->set_selected_id($cd->reservation_route);
	}

	public function view()
	{
		$this->_reservation_route->view();
	}
	public function get_name() : string
	{
		return 	"予約経路";
	}
	
	public function save()
	{
		$this->_customer_data->reservation_route = $this->_reservation_route->get_value();
	}
}

class EnableDMDetailItem extends DetailItem
{
	public function view()
	{
		if($this->_customer_data->enable_dm == 0)
		{
		?>
		<input type="checkbox" name="enable_dm" value='enable_dm' />							
		<?php
		}else{
		?>
		<input type="checkbox" name="enable_dm" value='enable_dm' checked="checked" />						
		<?php
		}
	
	}

	public function get_name() : string
	{
		return 	"DM不可";
	}
	
	public function save()
	{
		if(empty($_POST["enable_dm"]))
		{
			$this->_customer_data->enable_dm = 0;
		}else{
			$this->_customer_data->enable_dm = 1;
		}
	}
}

class RemarkDetailItem extends DetailItem
{
	public function view()
	{
		?>
		<input name='remarks' type="text" value='<?php echo $this->_customer_data->remarks; ?>' />
		<?php	
	}

	public function get_name() : string
	{
		return 	"備考";
	}
	
	public function save()
	{
		$this->_customer_data->remarks = $_POST["remarks"];
	}
}

?>