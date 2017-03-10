<?php
namespace ui\menu\frame;
require_once('menu-frame.php');
require_once('main-menu-factory.php');

function menu_frame_factory() : MenuFrame
{
	$main = main_menu_factory();
	return new MenuFrame($main);
}

?>