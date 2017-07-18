<?php
namespace ui\sales;

class SalesContext
{
	private static $_instance;
	public $sales_mail_context;
	const FROM_KEY = 'from_month';
	const TO_KEY = 'to_month';

	private function __construct()
	{
		$this->sales_mail_context = new SalesMailContext();
	}

	public $view_mode;

	public function enable_view_graph() : bool
	{
		return isset($_POST[SalesContext::FROM_KEY]) && isset($_POST[SalesContext::TO_KEY]);
	}
	
	public function get_from_month()
	{
		return $_POST[SalesContext::FROM_KEY];
	}

	public function get_to_month()
	{
		return $_POST[SalesContext::TO_KEY];
	}

	public static function get_instance() : SalesContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new SalesContext();
		}
		return self::$_instance;
	}
}

class SalesMailContext
{
    const EditBtnName = "EditFlg";
    const NewBtnName = "new_btn";
	const MailEditBtnName = "mail_edit";
    const EditValueName = "EditValue";
	const NewValueName = "NewValue";
    const EditKeyValue = "edit";
    const NewKeyValue = "new";
    const SaveKey = "SaveKey";
	const DeleteBtnName = "delete_btn";

    public function get_edit_sales_id()
    {
        if(isset($_POST[self::EditBtnName])){
            return $_POST[self::EditBtnName];
        }else{
            return "";
        }
    }

    public function get_delete_sales_id()
    {
        if(isset($_POST[self::DeleteBtnName])){
            return $_POST[self::DeleteBtnName];
        }else{
            return "";
        }
    }
	
    public function is_edit():bool
    {
        return isset($_POST[self::EditBtnName]);
    }
  
	public function is_mail_edit_click():bool
    {
        return isset($_POST[self::MailEditBtnName]);
    }
}

?>