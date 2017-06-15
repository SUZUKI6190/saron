<?php
namespace business\facade;
namespace business\entity\YoyakuRegistration;

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

function select_yoyaku_registration_by_staffid($id)
{
	global $wpdb;

    $result = $wpdb->get_results(	<<<SQL
		select * from yoyaku_registration
        where staff_id = '$id'
        order by  id
SQL);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}


function insert_yoyaku_registration(YoyakuRegistration $y)
{
	global $wpdb;
    $course_id_list = implode($y->coutse_id_list);
	$wpdb->query(
		<<<SQL
		insert into yoyaku_registration (
            staff_id,
            customer_id,
            start_time,
            coutse_id_list,
            schedule_division,
            consultation
		)values(
            staff_id = '$y->staff_id',
            customer_id = '$y->customer_id',
            start_time = '$y->start_time',
            coutse_id_list = '$coutse_id_list',
            schedule_division = '$y->schedule_division',
            consultation = '$y->consultation'
		)
SQL
);
}

?>