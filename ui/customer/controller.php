<?php
namespace ui\customer;
require_once('customerdetail.php');
require_once('customerDetailNew.php');
require_once('customerDetailEdit.php');

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

?>