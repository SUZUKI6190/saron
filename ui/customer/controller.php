<?php
namespace ui\customer;
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');
require_once('customer-search.php');

class ControlContext
{
	public $Page;
	public $RegistMode;
	public $Id;
	public $TemplatePageName;
	public $SearchResult;
	public function GetCustomerUrl()
	{
		return get_bloginfo('url')."/".$this->TemplatePageName."/customer";
	}
}

function ViewDetail()
{
	$data = new \business\entity\Customer();
	CreateCustomerDetailForm($data);
}

?>