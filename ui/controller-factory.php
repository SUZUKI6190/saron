<?php
namespace ui;
require_once('i-controller.php');
require_once('manage-controller.php');
require_once("customer/customer-download.php");
require_once("i-edit.php");
require_once(dirname(__FILE__).'/frame/manage-frame-context.php');
require_once(dirname(__FILE__).'/frame/manage-frame.php');
require_once(dirname(__FILE__).'/frame/result.php');
require_once('manage-frame-implementer-factory.php');
require_once('yoyaku/yoyaku-controller.php');

function create_controller() : IController
{
	$category = get_query_var("category");
	if($category == "download"){
		\ui\customer\get_customer_csv();
		exit;
	}elseif($category == "yoyaku"){
		return new \ui\yoyaku\YoyakuController();
	}else{
		return new ManageController();	
	}
}

?>