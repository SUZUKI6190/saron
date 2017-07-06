<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
require_once('customer-search-factory.php');
require_once('customer-search-item.php');
require_once('customer-detail.php');
require_once('customer-detail-edit-viewer.php');
require_once('search-viewer.php');
require_once('customer-list-viewer.php');

class SearchSub extends CustomerSubBase
{	
	private $_viewer;

	public function pre_view()
	{

	}

	public function init()
	{
		$this->_viewer = $this->create_viewer();
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