<?php
namespace business\entity;

class Config
{
    private static $_instance;
    private $_value_table = [];
    public $YoyakuMailAddress;

    private function __construct()
	{
        \business\facade\get_config($this);
        $this->YoyakuMailAddress = new ConfigParam(0, $this->_value_table);
    }

    public function set_value(int $id, string $value)
    {
        $this->_value_table[$id] = $value;
    }

    public static function get_instance() : self
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

}

class ConfigParam
{
    private $_id;
    private $_value_table = [];

    public function __construct($id, $table)
    {
        $this->_id = $id;
        $this->_value_table = $table;
    }

    public function get_value()
    {
        if(isset($this->_value_table[$this->_id])){
            return $this->_value_table[$this->_id];
        }else{
            return "";
        }  
    }

    public function save_value($value)
    {
        \business\facade\set_config($this->_id, $value);
        $this->_value_table[$this->_id] = $value;
    }

}
?>