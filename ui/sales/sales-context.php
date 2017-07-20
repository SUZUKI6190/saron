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

	const ListID = 'ListPage';
    const NewID = 'NewRegistPage';
    const EditID = 'EditRegistPage';
    const ContentID = 'MailContentPage';

    const key_list = [
        SalesMailContext::NewID,
        SalesMailContext::EditID,
        SalesMailContext::ListID,
        SalesMailContext::ContentID
    ];

	public function get_page_id()
	{
    	foreach(self::key_list as $k)
        {
            if(isset($_POST[$k])){
                return $k;
            }
        }

		return '';
	}

	public function get_pre_page_id()
	{
		if(isset($_POST[self::PageIdKey])){
			return $_POST[self::PageIdKey];
		}else{
			return '';
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