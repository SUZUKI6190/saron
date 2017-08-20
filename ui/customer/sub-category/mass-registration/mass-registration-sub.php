<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
require_once(dirname(__FILE__).'/err-obj-factory.php');

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
		$row_count = 1;
		foreach($file as $line)
		{
			if(substr($line[0], 0 , 1) == "#"){
				//コメントアウト行
				continue;
			}

			if(count($line) <= 1){
				//空行対策
				continue;
			}

			$data = \business\entity\Customer::create_from_csv($line);

			if(!is_null($data)){
				$err_obj = ErrObjBaseFactory::create_err_obj($data);

				if(is_null($err_obj)){
					$customer_data_list[] = $data;
				}else{
					$this->_err_data_list[$row_count] = $err_obj;
				}			
			}

			$row_count++;
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
					<th>行番号</th>
					<th>エラー内容</th>
				</tr>
			</thead>
			<?php
			foreach($this->_err_data_list as $row_no => $err_obj){
			?>
				<tr>
					<td><?php echo $row_no; ?></td>
					<td>
					<?php $err_obj->view_err_msg(); ?>
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

?>