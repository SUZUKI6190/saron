<?php
namespace ui\sales;
require_once('date-base.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;
use business\entity\ReservedCourse;

class SalesMailSettingSub extends \ui\frame\SubCategory
{

	public function init()
	{
	}


	public function view()
	{
	
	}

    
	public function get_name()
	{
		return "salesmail";
	}
	
	public function get_title_name()
	{
		return "売上メール設定";
	}
	
}
?>