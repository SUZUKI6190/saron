<?php
namespace ui\customer;
use ui\frame\ManageFrameContext;

class CustomerContext
{
	private static $_instance;
	public $SearchResult;
	private function __construct()
	{
	}
	public static function get_instance() : self
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function get_customer_url() : string
	{
		$mc = ManageFrameContext::get_instance();
		return get_bloginfo('url')."/".$mc->template_page_name."/customer";
	}
}
?>