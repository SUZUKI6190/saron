<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;

class MassRegistrationSub extends CustomerSubBase
{
	private static $post_key = "up_file";
	
	public function view()
	{
		if($this->is_upload()){
			$this->import();
		}else{
			$cc = CustomerContext::get_instance();
			$d = "?date=".(new \DateTime())->format("Ymdhis");
			?>
			<div class="input_form centering">
			<form action='<?php echo "$d" ?>' method="post" enctype="multipart/form-data">
				<input type="file" id="inp" name="<?php echo self::$post_key; ?>"  />
				<button type="submit" class="manage_button">アップロード</button>
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
			if(substr($line[0], 0 , 1) == "#"){
				continue;
			}
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


?>