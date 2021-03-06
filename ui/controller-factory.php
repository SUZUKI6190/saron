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
require_once(dirname(__FILE__).'/yoyaku/yoyaku-controller.php');
require_once(dirname(__FILE__).'/image/download-image.php');
require_once(dirname(__FILE__).'/../business/facade/yoyaku.php');
require_once(dirname(__FILE__).'/../business/entity/yoyaku.php');
require_once(dirname(__FILE__).'/../business/facade/sales-mail-setting.php');
require_once(dirname(__FILE__).'/../business/entity/sales-mail-setting.php');
require_once(dirname(__FILE__).'/../business/facade/reserved.php');
require_once(dirname(__FILE__).'/../business/entity/reserved.php');
require_once(dirname(__FILE__).'/../business/facade/schedule.php');
require_once(dirname(__FILE__).'/../business/entity/schedule.php');
require_once(dirname(__FILE__)."/../business/facade/publish-menu.php");
require_once(dirname(__FILE__)."/../business/facade/config.php");
require_once(dirname(__FILE__)."/../business/entity/config.php");
require_once(dirname(__FILE__).'/../business/facade/customer.php');
require_once(dirname(__FILE__).'/../business/entity/customer.php');

require_once(dirname(__FILE__).'/../business/entity/sold.php');
require_once(dirname(__FILE__).'/../business/facade/sold.php');

function create_controller() : IController
{
	$category = get_query_var("category");
	if($category == "download"){
		\ui\customer\get_customer_csv();
		exit;
	}elseif($category == 'image'){
		$id = get_query_var('id');
		$sub_id = get_query_var('sub_id');
		\ui\image\ImageDonwloader::create_page($id, $sub_id);
		exit;
	}elseif($category == "yoyaku"){
		return new \ui\yoyaku\YoyakuController();
	}else{
		require_once(dirname(__FILE__).'/../business/facade/staff-schedule.php');
		require_once(dirname(__FILE__).'/../business/entity/staff-schedule.php');
		require_once(dirname(__FILE__).'/frame/sub-cotegory.php');
		return new ManageController();	
	}
}

?>