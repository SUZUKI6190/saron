<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
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
			$this->transfer($cc->get_donwload_url());
		}
	}

	protected function transfer($url)
	{
		$d = "?date=".(new \DateTime())->format("Ymdhis");
		$new_url = $url.$d;
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=data.csv');
		header("Content-type: text/html; charset=utf-8");
		$id_list = str_getcsv( $_POST[CustomerDownload::CUSTOMER_ID_NAME]);
		
		$ret = "";
		
		foreach($id_list as $id)
		{
			$ret = $ret.\business\facade\SelectCustomerById($id)->serialize_csv()."\n";
		}

		$ret = rtrim($ret, '\n');
		
		$stream = fopen('php://output', 'w');

		fputcsv($stream, str_getcsv($ret));
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
			return new CustomerDetailEditViewer();
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