<?php
namespace ui\customer;
use business\entity\Customer;
use ui\util;
require_once('customer-detail-item.php');
require_once(dirname(__FILE__)."/../../staff.php");

abstract class CustomerDetail
{
	private $_view_staff;
	private $_birth;
	private $_last_visit_date;
	private $_next_visit_reservation_date;

	protected abstract function create_header();
	public abstract function create_customer_data();
	protected abstract function save_inner(Customer $data);
	public abstract function init();

	public function __construct()
	{
		$this->_view_staff = new \ui\ViewStaff("staff");
		$this->_birth = new \ui\util\view_date_input("birth");
		$this->_last_visit_date = new \ui\util\view_date_input("last_visit_date");
		$this->_next_visit_reservation_date= new \ui\util\view_date_input("next_visit_reservation_date");
	}

	public function view()
	{
		$data = $this->create_customer_data();
		$this->CreateForm($data);
	}

	private function ConvertInputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
	}

	public function save()
	{
		$data = new Customer();
		$item_list = $this->get_item_list($data);
		
		$result = array_filter($item_list, function($item){
			return !$item->input_check();
		});
		
		if(count($result) > 0)
		{
			$this->View();
			return;
		}
		
		foreach($item_list as $item)
		{
			$item->save();
		}
		
		$this->save_inner($data);

		?>

		<div class="regist_finish">
			<span>登録が完了しました。</span>
		</div>

		<?php
	}

	protected static $SavePostKey = 'save';

	public function is_save_post()
	{
		return isset($_POST[CustomerDetail::$SavePostKey]);
	}

	protected function get_item_list(Customer $c)
	{
		return [
			new KanjiNameDetailItem($c),
			new KanaNameDetailItem($c),
			new TellDetailItem($c),
			new MailDetailItem($c),
			new SexDetailItem($c),
			new OldDetailItem($c),
			new BirthDetailItem($c),
			new AddressDetailItem($c),
			new OccupationDetailItem($c),
			new NumberOfVisitDetailItem($c),
			new StaffDetailItem($c),
			new LastVisitDateDetailItem($c),
			new NextVisitReservationDateDetailItem($c),
			new ReservationRouteDetailItem($c),
			new EnableDMDetailItem($c),
			new RemarkDetailItem($c)
		];
	}

	private function required_text()
	{
		?>
		<span style="color:red;">※入力必須</span>
		<?php
	}
	
	protected function on_pre_view()
	{
	}
	
	protected function CreateForm(Customer $data)
	{
		$this->on_pre_view();
	?>
		<div class="wrap">
			<?php
			$this->create_header();
			?>
			<div class="input_form detail">
				<div class="area">
					<?php
					$view_func;
					if($this->is_save_post()){
						$view_func = function($item)
						{
							?>
							<div class="line">
								<h2>
									<?php echo $item->get_name(); ?>:
								</h2>
								<?php 
								if(!$item->input_check())
								{
									?>
									<div class="detail_input_error">
										<span><?php echo $item->get_err_msg(); ?></span>
									</div>
									<?php 
								}
								echo $item->view();
								?>
							</div>
							<?php
						};
					}else{
						$view_func = function($item)
						{
							?>
							<div class="line">
								<h2>
									<?php echo $item->get_name(); ?>:
								</h2>
								<?php 
								echo $item->view();
								?>
							</div>
							<?php
						};
					}
					foreach($this->get_item_list($data) as $item)
					{
						$view_func($item);
					}
					?>
	
				</div>
			</div>
		</div>
		<?php
	}
}
?>