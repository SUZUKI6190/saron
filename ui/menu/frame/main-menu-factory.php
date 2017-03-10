<?php
namespace ui\menu\frame;
require_once(dirname(__FILE__).'/../main/menu-select.php');

use ui\menu\MenuContext;
use ui\menu\main\MenuSelect;

function main_menu_factory() : MainMenu
{
	$contxt = MenuContext::get_instance();
	
	return new MenuSelect();
}
?>
