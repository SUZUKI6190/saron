<?php

namespace business\facade;
/*
use business\entity\YoyakuRegistration;

function delete_yoyaku_registration_byid($id)
{
	global $wpdb;
    $course_id_list = implode($y->coutse_id_list);
	$wpdb->query(
		<<<SQL
		delete from yoyaku_registration where id = '$id'
SQL
);
}

function update_yoyaku_registration_byid(YoyakuRegistration $y)
{
    $strSql = <<<SQL
            update `customer` set
            name = '$menu->name',
            description = '$menu->description',
            enable_reservation = '$menu->enable_reservation',
        where id = '$data->id'
SQL;

}

function insert_yoyaku_registration($y)
{
	global $wpdb;
    $course_id_list = implode(',', $y->coutse_id_list);
    $strSql = <<<SQL
		insert into yoyaku_registration (
            staff_id,
            customer_id,
            start_time,
            course_id_list,
            schedule_division,
            consultation
		)values(
            '$y->staff_id',
            '$y->customer_id',
            '$y->start_time',
            '$course_id_list',
            '$y->schedule_division',
            '$y->consultation'
		)
SQL;
	$wpdb->query($strSql);
}

function select_yoyaku_registration_by_staffid($id)
{
	global $wpdb;

    $result = $wpdb->get_results(<<<SQL
		select * from yoyaku_registration
        where staff_id = '$id'
        order by  id
SQL
);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}
*/

?>