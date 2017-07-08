<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;
require_once("customer-detail-new.php");

class RegistNewSub extends CustomerSubBase
{	
	public function view()
	{
		$cc = CustomerContext::get_instance();
		$d = "?date=".(new \DateTime())->format("Ymdhis");
?>
	<form method='post' action='<?php echo "$d" ?>'>
	<?php
		$detailView = new CustomerDetailNew();
		$detailView->init();
		$detailView->view();
	?>
	</form>
	<?php	
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

?>