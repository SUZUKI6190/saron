<?php
namespace ui\yoyaku;
require_once('frame/yoyaku-frame.php');

use ui\yoyaku\YoyakuContext;
use ui\yoyaku\menu\YoyakuSelect;
use ui\yoyaku\menu\StaffSelect;
use ui\yoyaku\menu\DaySelect;
use ui\yoyaku\menu\MailInput;
use ui\yoyaku\menu\Confirm;

function main_yoyaku_factory() : \ui\yoyaku\frame\YoyakuMenu
{
	$yc = YoyakuContext::get_instance();
	$yc->template_page_name = get_query_var( 'pagename' );

	$menu;
	switch($yc->sub_category)
	{
		case 'menu':
			require_once('menu/yoyaku-select.php');
			$menu = new YoyakuSelect();
			break;
		case 'staff':
			require_once('menu/staff-select.php');
			$menu = new StaffSelect();
			break;
		case 'day':
			require_once('menu/day-select.php');
			require_once(dirname(__FILE__)."/../../business/entity/schedule.php");
			require_once(dirname(__FILE__)."/../../business/facade/schedule.php");
			require_once(dirname(__FILE__).'/../util/holyday-datetime.php');
			$menu = new DaySelect();
			break;
		case 'mailform':
			require_once('menu/mail-input.php');
			$menu = new MailInput();
			break;
		case 'confirm':
			require_once('menu/confirm.php');
			$menu = new Confirm();
			break;
	}
	return $menu;
}
?>