<?php
namespace ui\customer;
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