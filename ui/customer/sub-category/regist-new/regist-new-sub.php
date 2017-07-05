<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;

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

?>