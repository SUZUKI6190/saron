<?php
namespace business\facade;
require_once(dirname(__FILE__).'/../entity/menu.php');
require_once(dirname(__FILE__).'/../entity/menu-course.php');
use business\entity\Menu;
use business\entity\MenuCourse;

function get_menu_list()
{
	$ret = [];
	
	$test = new Menu();
	$test->name = "test";
	$test->price = 3000;
	$test->time_required = 30;
	$ret[] = $test;
	return $ret;
}

?>