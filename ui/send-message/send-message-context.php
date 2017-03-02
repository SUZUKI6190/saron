<?php
namespace ui\send_message;

class SendMessageContext
{
	private static $_instance;
	private function __construct()
	{
	}

	public $message_id;
	
	public static function get_instance() : SendMessageContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SendMessageContext();
		}
		return self::$_instance;
	}
}

?>