<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\CustomerIntervalSetting;
use \business\facade;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once(dirname(__FILE__).'/../../business/entity/customer_interval_setting.php');
require_once(dirname(__FILE__).'/../../business/facade/customer.php');

abstract class CustomerSubBase extends \ui\frame\SubCategory
{
	protected $_context;
	public function __construct(ControlContext $context)
	{
		$this->_context = $context;
	}
}

class SearchSub extends CustomerSubBase
{	
	public function view()
	{
		$newUrl = $this->_context->GetCustomerUrl()."/new/";
		$searchUrl = $this->_context->GetCustomerUrl()."/search/";

		if($this->_context->RegistMode == 'detail'){
			$detailView;
			$detailView = new CustomerDetailEdit($this->_context->Id);
			if($detailView->IsSavePost()){
				$detailView->Save();
			}else{
				$detailView->View();
			}
			exit;
		}
		
		view_search($this->_context);

	
	}
	
	public function get_name()
	{
		return "search";
	}
	
	public function get_title_name()
	{
		return "お客様検索";
	}
}


class RegistNewSub extends CustomerSubBase
{	
	public function view()
	{
		$detailView = new CustomerDetailNew();
		if($detailView->IsSavePost()){
			$detailView->Save();
		}else{
			$detailView->View();
		}
	}
	
	public function get_name()
	{
		return "new";
	}
	
	public function get_title_name()
	{
		return "新規登録";
	}
}


class MassRegistrationSub extends CustomerSubBase
{
	private static $post_key = "up_file";
	
	public function view()
	{
		if($this->is_upload()){
			$this->import();
		}else{
			?>
			<div class="input_form centering">
			<form action="" method="post" enctype="multipart/form-data">

				<input type="file" id="inp" name="<?php echo self::$post_key; ?>"  />
		

			<?php
			\ui\util\submit_button("アップロード");
			?>
			</form>
			</div>
			<?php
		}
	}
	
	private function is_upload()
	{
		if(empty($_FILES[self::$post_key]))
		{
			return false;
		}
		return is_uploaded_file($_FILES[self::$post_key]["tmp_name"]);
	}
	
	private function import()
	{

		$file = new SplFileObject($_FILES[self::$post_key]['tmp_name']);
		$file->setFlags(SplFileObject::READ_CSV); 
	
		$customer_data_list = [];
		foreach($file as $line)
		{
			$data = \business\entity\Customer::create_from_csv($line);
			if(!is_null($data)){
				$customer_data_list[] = $data;
			}
		}
	
		foreach($customer_data_list as $customer)
		{
			\business\facade\InsertCustomer($customer);
		}
		
		?>
		<span>登録完了しました。</span>
		<?php
		
	}

	public function get_name()
	{
		return "upload";
	}
	
	public function get_title_name()
	{
		return "一括登録";
	}
}


class DeleteSub extends CustomerSubBase
{	
	private static $month_list = [3,6,9,12,15];
	private function setup_cron()
	{
	}

	public function view()
	{
		if(!empty($_POST["confirm_cron"]))
		{
			$data = new CustomerIntervalSetting();
			$data->id = CustomerIntervalSetting::DeleteID;
			$data->value = $_POST["selected_month"];
			\business\facade\set_customer_interval_setting($data);
		}
		$saved_month = \business\facade\get_interval_setting_byid(CustomerIntervalSetting::DeleteID);
		?>

		<form method="post" action=""　>
		<div class="input_form centering">
			<div class = "delete_item">
				<span>
					最終来店日から
				</span><br>
				<select name='selected_month'>
				<?php
				foreach(DeleteSub::$month_list as $month)
				{
					if($month == $saved_month)
					{
						echo "<option value='$month' selected>$month</option>";	
					}else{
						echo "<option value='$month'>$month</option>";	
					}
				}
				?>
				</select>か月<br>
				<span>
					経過したお客様情報を自動で削除
				</span>
			<div>
			
			<div class = "bottom_button_area">
				<?php \ui\util\submit_button('確定する', "confirm_cron"); ?>
			</div>
		</div>
		</form>
		<?php
	
	}
	
	public function get_name()
	{
		return "delete";
	}
	
	public function get_title_name()
	{
		return "一括削除";
	}
}

?>