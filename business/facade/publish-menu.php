<?php
namespace business\facade;
require_once(dirname(__FILE__).'/../entity/menu.php');
require_once(dirname(__FILE__).'/../entity/menu-course.php');
use business\entity\Menu;
use business\entity\MenuCourse;

function get_menu_list($id = "")
{
	$strSql = <<<SQL
		select
		id,
		name,
		price,
		description,
		time_required,
		enable_reservation
		from menu
SQL;

	if(!empty($id))
	{
		$strSql = $strSql." where id = '$id'";
	}

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_map(function($data) {
		$temp = new Menu();
		$temp->menu_id = $data->id;
		$temp->name = $data->name;
		$temp->price = $data->price;
		$temp->time_required = $data->time_required;
		$temp->description = $data->description;
		$temp->enable_reservation = $data->enable_reservation;
		return $temp;
	}, $result);

	return $ret;
}

function get_menu_by_id($id) : Menu
{
	$ret = get_menu_list($id);
	return $ret[0];
}


function delete_menu($id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from menu
		where id = '$id'
SQL
);
}

function insert_menu(Menu $menu)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
insert into menu (
	name,
	price,
	description,
	time_required,
	enable_reservation
)values(
	'$menu->name',
	'$menu->price',
	'$menu->description',
	'$menu->time_required',
	'$menu->enable_reservation'
)
SQL
);
}

function update_menu(Menu $menu)
{
	$strSql = <<<SQL
		update `customer` set
		name = '$menu->name',
		price = '$menu->price',
		description = '$menu->description',
		time_required = '$menu->time_required',
		enable_reservation = '$menu->enable_reservation',
	where id = '$data->id'
SQL;
	global $wpdb;
	$wpdb->query($strSql);
}

function get_menu_course_by_menuid($menu_id)
{
	$strSql = <<<SQL
		select
		id,
		menu_id,
		name,
		price,
		time_required
		from menu_course
		where menu_id = '$menu_id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		$temp = new MenuCourse();
		$temp->id = $data->id;
		$temp->menu_id = $data->menu_id;
		$temp->name = $data->name;
		$temp->price = $data->price;
		$temp->time_required = $data->time_required;
		return $temp;
	}, $result));

	return $ret;
}


function get_menu_course($id, $menu_id)
{
	$strSql = <<<SQL
		select
		id,
		menu_id,
		name,
		price,
		time_required
		from menu_course
		where menu_id = '$menu_id'
		  and id = '$id'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		$temp = new MenuCourse();
		$temp->id = $data->id;
		$temp->menu_id = $data->menu_id;
		$temp->name = $data->name;
		$temp->price = $data->price;
		$temp->time_required = $data->time_required;
		return $temp;
	}, $result));

	return $ret;
}

function delete_menu_course($id, $menu_id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from menu_course
		where id = '$id'
		  and menu_id = '$menu_id'
SQL
);
}

function delete_menu_course_by_menuid($menu_id)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from menu_course
		where menu_id = '$menu_id'
SQL
);
}

function insert_menu_course(MenuCourse $mc)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into menu_course (
			menu_id,
			name,
			price,
			time_required
		)values(
			'$mc->menu_id',
			'$mc->name',
			'$mc->price',
			'$mc->time_required'
		)
SQL
);
}

?>