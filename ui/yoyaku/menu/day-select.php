<?php
namespace ui\yoyaku\menu;
require_once(dirname(__FILE__).'/../controll/menu-table.php');
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;

class DaySelect extends YoyakuMenu
{
	public function __construct()
	{


	}
	
	public function get_title() : string
	{
		return "日時選択";
	}
	
	public function view()
	{
		$yc = YoyakuContext::get_instance();

	}
}

?>