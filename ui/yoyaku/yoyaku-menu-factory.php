<?php
namespace ui\yoyaku;
require_once('menu/yoyaku-select.php');
require_once('frame/yoyaku-frame.php');

use ui\yoyaku\YoyakuContext;
use ui\yoyaku\menu\YoyakuSelect;

function main_yoyaku_factory() : \ui\yoyaku\frame\YoyakuMenu
{
	$yc = YoyakuContext::get_instance();
	
	$menu;
	switch($yc->sub_category)
	{
		case 'menu':
			$menu = new YoyakuSelect();
			break;
		case 'staff':
			$menu = new YoyakuSelect();
			break;
	}
	return $menu;
}
?>