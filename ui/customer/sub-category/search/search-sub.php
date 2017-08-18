<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
use \business\entity\Customer;

require_once('customer-search-factory.php');
require_once('customer-search-item.php');
require_once('customer-detail-edit-viewer.php');
require_once('search-viewer.php');
require_once('customer-list-viewer.php');

class SearchSub extends CustomerSubBase
{	
	private $_viewer;

	public function pre_view()
	{
		$cc = CustomerContext::get_instance();
		if($cc->is_csv_btn_click())
		{
			$this->donwload_csv();
		}
	}

	protected function donwload_csv()
	{
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=data.csv');
		header("Content-type: text/html; charset=shift_jis");
		
		$id_list = str_getcsv( $_POST[CustomerDownload::CUSTOMER_ID_NAME]);
		
		$ret = "";
		$ret = $ret.(Customer::create_csv_header())."\n";
		foreach($id_list as $id)
		{
			$ret = $ret.(\business\facade\SelectCustomerById($id)->serialize_csv())."\n";
		}

		echo mb_convert_encoding($ret,'SJIS-win','utf8');

		exit;
	}

	public function init()
	{
		$this->_viewer = $this->create_viewer();
		$this->_viewer->init();
	}

	private function create_viewer() : SearchViewer
	{
		$cc = CustomerContext::get_instance();
		if($cc->RegistMode == 'detail'){
			return new CreateForm();
		}
		return new CustomerListViwer();
	}

	public function view()
	{
		$cc = CustomerContext::get_instance();
		$newUrl = $cc->get_customer_url()."/new/";
		$searchUrl = $cc->get_customer_url()."/search/";
		$d = "?date=".(new \DateTime())->format("Ymdhis");
?>
	<form method='post' action='<?php echo "$d" ?>'>
	<?php
		$this->_viewer->view();
	?>
	</form>
	<?php
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

?>