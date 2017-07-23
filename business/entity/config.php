<?php
namespace business\entity;

class Config
{
    private static $_instance;
    private $_value_table = [];
    //予約送信メール設定
    public $YoyakuMailAddress;
    public $YoyakuMailTitle;
    public $YoyakuMailContent;
    //お客様情報定期削除設定
    public $IntervalDeleateCusotomer;
    //売上メール送信設定
    public $SalesMailTitle;
    public $SalesMailMessage;
    public $SalesMailUserName;
    public $SalesMailUserAddress;

    const YoyakuMailAddressId = 1;
    const YoyakuMailTitleId = 2;
    const YoyakuMailContentId = 3;
    const IntervalDeleateCustomersId = 4;
    const SalesMailTitleId = 5;
    const SalesMailMessageId = 6;
    const SalesMailUserNameId = 7;
    const SalesMailUserAddressNameId = 8;

    private function __construct()
	{
        \business\facade\get_config($this);
        $this->YoyakuMailAddress = $this->create_param(self::YoyakuMailAddressId);
        $this->YoyakuMailTitle = $this->create_param(self::YoyakuMailTitleId);
        $this->YoyakuMailContent = $this->create_param(self::YoyakuMailContentId);
        $this->IntervalDeleateCustomers = $this->create_param(self::IntervalDeleateCustomersId);
        $this->SalesMailTitle = $this->create_param(self::SalesMailTitleId);
        $this->SalesMailMessage = $this->create_param(self::SalesMailMessageId);
        $this->SalesMailUserName = $this->create_param(self::SalesMailUserNameId);
        $this->SalesMailUserAddress = $this->create_param(self::SalesMailUserAddressNameId);
    }

    private function create_param($id) : ConfigParam
    {
        return new ConfigParam($id, $this->_value_table);
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