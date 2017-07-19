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
	const DeleteBtnName = "delete_btn";

	const PageIdKey = "PageNo";
	const PrePageIdKey = "PrePageNo";

	const ListID = 'ListPage';
    const NewID = 'NewRegistPage';
    const EditID = 'EditRegistPage';
    const ContentID = 'MailContentPage';

	public function get_page_id()
	{
		if(isset($_POST[self::PageIdKey])){
			return $_POST[self::PageIdKey];    
		}else{
			return '';
		}
	}

	public function get_pre_page_id()
	{
		if(isset($_POST[self::PrePageIdKey])){
			return $_POST[self::PrePageIdKey];
		}else{
			return '';
		}
	}

    public function get_edit_sales_id()
    {
        if(isset($_POST[self::EditID])){
            return $_POST[self::EditID];
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
}

?>