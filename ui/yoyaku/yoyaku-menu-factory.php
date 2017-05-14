<?php
namespace ui\yoyaku;
require_once('menu/yoyaku-select.php');
require_once('menu/staff-select.php');
require_once('menu/day-select.php');
require_once('frame/yoyaku-frame.php');

use ui\yoyaku\YoyakuContext;
use ui\yoyaku\menu\YoyakuSelect;
use ui\yoyaku\menu\StaffSelect;
use ui\yoyaku\menu\DaySelect;

function main_yoyaku_factory() : \ui\yoyaku\frame\YoyakuMenu
{
	$yc = YoyakuContext::get_instance();
	$yc->template_page_name = get_query_var( 'pagename' );

	$menu;
	switch($yc->sub_category)
	{
		case 'menu':
			$menu = new YoyakuSelect();
			break;
		case 'staff':
			$menu = new StaffSelect();
			break;
		case 'day':
			require_once(dirname(__FILE__)."/../../business/entity/schedule.php");
			require_once(dirname(__FILE__)."/../../business/facade/schedule.php");
			$menu = new DaySelect();
			break;
	}
	return $menu;
}
?>