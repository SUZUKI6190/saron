<?php
namespace ui\send_message;
require_once(dirname(__FILE__).'/../frame/manage-frame.php');
require_once('sub-category/send-message-sub-cotegory.php');
use \ui\frame\ManageFrameImplementor;
use \ui\send_message\sub_category\SettingSub;

class SendMessageImplementor extends ManageFrameImplementor
{
	public function get_sub_category_list()
	{
		$ret =[];
		$set_array = function ($sub) use(&$ret)
		{
			$ret[$sub->get_name()] = $sub;
		};
		$set_array(new SettingSub());

		
		return $ret;
	}

	public function view_main()
	{
		
	}
}
	


?>