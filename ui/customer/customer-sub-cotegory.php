<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');

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
			<form action="" method="post" enctype="multipart/form-data">
			  <input type="file" name="<?php echo self::$post_key; ?>" size="30" />
			  <input type="submit" value="アップロード" />
			</form>
			<?php
		}
	}
	
	private function is_upload()
	{
		return is_uploaded_file($_FILES[self::$post_key]["tmp_name"]);
	}
	
	private function import()
	{

		$file = new SplFileObject($_FILES[self::$post_key]['tmp_name']);
		$file->setFlags(SplFileObject::READ_CSV); 
	
		$map = function($csv){
			return Customer::create_from_csv($csv);
		};
		
		$customer_data_list = [];
		foreach($file as $line)
		{
			$customer_data_list[] = \business\entity\Customer::create_from_csv($line);
		}
		print_r($customer_data_list	);
		?>
		<span>登録完了しました。</span>
		<?php
/*
		$tmp = fopen($_FILES[self::$post_key]['tmp_name'], "r");
		$ret = [];
		try
		{
			// ファイル内容を出力
			while ($line = fgets($tmp)) {
			  $ret[] = $line;
			}
		}finally{
			// ファイルポインタをクローズ
			fclose($tmp);
		}
		*/
		
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