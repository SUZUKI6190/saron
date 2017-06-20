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

    public function set_value(int $value)
    {
        $this->_value_table[$this->_id] = $value;
    }

    public function get_value()
    {
        if(isset($this->_value_table[$this->_id])){
            return $this->_value_table[$this->_id];
        }else{
            return "";
        }  
    }

}
?>