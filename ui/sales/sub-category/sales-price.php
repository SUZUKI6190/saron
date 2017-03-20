<?php
namespace ui\sales;
use ui\frame\ManageFrameContext;
use \business\facade;
use \business\entity\sales;
use \ui\util\SubmitButton;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\salesContext;

class SalesPriceSub extends \ui\frame\SubCategory
{
	private $_form_id = "menu_form";
	public function __construct()
	{

	}
	public function view()
	{?>

		<?php
	}

	public function get_name()
	{
		return "price";
	}
	
	public function get_title_name()
	{
		return "売上";
	}
	
}
?>