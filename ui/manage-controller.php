<?php
namespace ui;
require_once("i-controller.php");
require_once("customer/customer-download.php");
require_once("i-edit.php");
require_once(dirname(__FILE__).'/frame/login.php');
require_once(dirname(__FILE__).'/frame/manage-frame-context.php');
require_once(dirname(__FILE__).'/frame/manage-frame.php');
require_once(dirname(__FILE__).'/frame/result.php');
require_once('manage-frame-implementer-factory.php');
require_once(dirname(__FILE__)."/util/control-util.php");
require_once(dirname(__FILE__)."/util/customer-reservation-route.php");
require_once(dirname(__FILE__).'/../business/facade/login.php');
require_once(dirname(__FILE__).'/../business/entity/login.php');

use \ui\frame;

class ManageController implements IController
{
	public function init()
	{
	}
	
	private function create_main_category()
	{
		$ret =[];
		$set_array = function ($name, $text, $default_name) use(&$ret)
		{
			$ret[$name] = new \ui\frame\MainCategory($name, $text, $default_name);
		};

		$set_array("customer", "お客様管理", "search");
		$set_array("publish", "掲載管理", "menu");
		$set_array("send_message", "メッセージ配信管理", "view");
		$set_array("schedule", "予約管理" , "day_of_the_week");
		$set_array("staff", "スタッフ管理", "view");
		$set_array("sales", "売り上げ管理", "price");

		return $ret;
	}

	public function view()
	{
		$mc = \ui\frame\ManageFrameContext::get_instance();
		$mc->main_category_list = $this->create_main_category();
		$mc->selected_main_category_name = get_query_var("category");
		$mc->selected_sub_category_name = get_query_var("sub_category");
		
		\ui\frame\Login::init();

		if(!$mc->is_login())
		{
			
			\ui\frame\Login::view();
			exit;
		}

		$inplementer = create_iplementer($mc->selected_main_category_name);

		$frame = new \ui\frame\ManageFrame($mc->main_category_list, $inplementer);
		$frame->pre_view();
		$frame->view();
		exit;
	}

}

?>