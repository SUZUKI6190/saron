<?php
namespace business\facade;
require_once(dirname(__FILE__).'/../entity/menu.php');
require_once(dirname(__FILE__).'/../entity/menu-course.php');
use business\entity\Menu;
use business\entity\MenuCourse;

function get_menu_list()
{
	$strSql = <<<SQL
		select
		id,
		name,
		price,
		description,
		time_required
		from menu
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_map(function($data) {
		$temp = new Menu();
		$temp->name = $result->name;
		$temp->price = $result->price;
		$temp->time_required = $result->time_required;
		$temp->description = $result->description;
		return $temp;
	}, $result);

	return $ret;
}

function get_menu_course_by_menuid($menu_id)
{
	$strSql = <<<SQL
		select
		menu_id,
		name,
		price,
		time_required
		from menu_course
		where id = '$menu_id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_map(function($data) {
		$temp = new MenuCiurse();
		$temp->id = $result->id;
		$temp->name = $result->name;
		$temp->price = $result->price;
		$temp->time_required = $result->time_required;
		return $temp;
	}, $result);

	return $ret;
}

?>