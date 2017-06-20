<?php
namespace business\entity;

class Config
{
    private static $_instance;
    private $_value_table = [];

    private function __construct()
	{
        \business\facade\get_config();
    }

    public static function get_instance() : self
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    public function set_value(int $id, int $value)
    {
        $this->_value_table[$id] = $value;
    }

    private function get_value(int $id)
    {
        return $this->_value_table[$id];
    }
}
?>