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
		$detailView = new CustomerDetailNew();
		if($detailView->is_save_post()){
			$detailView->save();
		}else{
			$detailView->view();
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

?>