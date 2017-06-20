<?php
namespace business\entity;

class Config
{
    private static $_instance;
    private $_value_table = [];

    private function __construct()
	{
        \business\facade\get_config($this);
    }

    public static function get_instance() : self
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

    public function set_value(int $id, int $value)
    {
        $this->_value_table[$id] = $value;
    }

    private function get_value(int $id)
    {
        if(isset($this->_value_table[$id])){
            return $this->_value_table[$id];
        }else{
            return "";
        }
        
    }

    public function get_yoyaku_mail_url() : string
    {
        return $this->get_value(0);
    }

}
?>