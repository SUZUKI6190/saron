<?php
namespace ui\customer;
use ui\frame\ManageFrameContext;

class CustomerContext
{
	const ExportBtnName = "csv_export";
	private static $_instance;
	public $SearchResult;
	
	private function __construct()
	{
	}

	public function is_csv_btn_click() : bool
	{
		return isset($_POST[self::ExportBtnName]);
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
		return $mc->get_url()."/customer";
	}

	public function get_donwload_url()
	{
		$mc = ManageFrameContext::get_instance();
		return $mc->get_url()."/download";
	}
}
?>