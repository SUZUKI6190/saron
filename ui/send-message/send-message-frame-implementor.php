<?php
namespace ui\send_message;
require_once('sub-category/setting-sub.php');
require_once('sub-category/view-message-sub.php');
require_once(dirname(__FILE__).'/../../business/entity/menu.php');
require_once(dirname(__FILE__).'/../../business/entity/menu-course.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');

use \ui\frame\ManageFrameImplementor;
use \ui\send_message\sub_category\SettingSub;
use \ui\send_message\sub_category\ViewMessageSub;

class SendMessageImplementor extends ManageFrameImplementor
{
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new ViewMessageSub());
		$set_array(new SettingSub());

		return $ret;
	}

	public function view_main()
	{
		
	}
	
	protected function get_css_list()
	{
		return [
			new \ui\frame\HeaderFile('send_message.css', 0.04)
		];
	}


	protected function get_js_list()
	{
		return [
			new \ui\frame\HeaderFile('send-message.js', 0.04)
		];
	}

	
}
	


?>