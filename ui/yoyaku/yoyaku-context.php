<?php
namespace ui\yoyaku;

class YoyakuContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $template_page_name;

	public function get_base_url()
	{
		$template_page_name = get_query_var( 'pagename' );
		return get_bloginfo('url')."/".$this->template_page_name."/yoyaku";
	}
	
	public $yoyaku_id;
	public $sub_category;
	
	public static function get_instance() : YoyakuContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new YoyakuContext();
		}
		return self::$_instance;
	}
}

?>