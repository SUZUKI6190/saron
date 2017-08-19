<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;

class MassRegistrationSub extends CustomerSubBase
{
	private static $post_key = "up_file";

	private $_err_data_list = [];
	
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

				$result = \business\facade\select_customer_id_and_visitnum_by_email($data->email);

				if(is_null($result)){
					$customer_data_list[] = $data;
				}else{
					$err_obj = new ErrObj();
					$err_obj->set_email($data->email);
					$err_obj->set_err_msg('重複したemailです。');		
					$this->_err_data_list[] = $err_obj;
				}
			}
		}
	
		foreach($customer_data_list as $customer)
		{
			\business\facade\InsertCustomer($customer);
		}
		
		?>
		<span>登録完了しました。</span>
		<?php

		if(count($this->_err_data_list) > 0){
			?>
			<div clas='err_area'>
			<table class='err_table'>
			<thead>
				<tr>
					<th>email</th>
					<th>詳細</th>
				</tr>
			</thead>
			<?php
			foreach($this->_err_data_list as $err_obj){
			?>
				<tr>
					<td>
					<?php echo $err_obj->get_email(); ?>
					</td>
					<td>
					<?php echo $err_obj->get_err_msg(); ?>
					</td>
				</tr>
			<?php
			}
			?>
			</table>
			</div>
			<?php
		}
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

class ErrObj
{
	public function get_email():string
	{
		return $this->_email;
	}

	public function get_err_msg():string
	{
		return $this->_err_msg;
	}

	public function set_email(string $email)
	{
		$this->_email = $email;
	}

	public function set_err_msg(string $msg)
	{
		$this->_err_msg= $msg;
	}
}

?>