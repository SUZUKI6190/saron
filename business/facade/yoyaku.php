<?php

namespace business\facade;

use business\entity\YoyakuRegistration;

function get_yoyaku_registration_by_date(\DateTime $from_date, \DateTime $to_date) : array
{
    global $wpdb;
    $f = $from_date->format('Ymd');
    $to = $to_date->format('Ymd');
    $strSql = <<<SQL
SELECT * FROM `yoyaku_registration`
WHERE start_time >= '$f'
  and start_time <= '$to'
SQL;

    $result = $wpdb->get_results($strSql);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}


function get_yoyaku_registration_last_3_years() : array
{
    global $wpdb;
    $strSql = <<<SQL
    SELECT * from yoyaku_registration
    WHERE  YEAR(start_time) BETWEEN YEAR(NOW()) - 2 AND YEAR(NOW())
    ORDER BY start_time ASC
SQL;

    $result = $wpdb->get_results($strSql);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    $group = [];

    foreach(array_map($convert, $result) as $yr)
    {
        $d = new \DateTime($yr->start_time);
        $year = ($d)->format('Y');
        $month =(int)($d)->format('m');
        $month_conut = 1;
        $group[$year] = [];
        while($month_conut <= 12)
        {
            if($month_conut == $month){
                $group[$year][$month_conut][] = $yr;
            }else{
                $group[$year][$month_conut] = [];
            }
            $month_conut++;
        }
        
    }

    return $group;
}


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
    $strSql = <<<SQL
		insert into yoyaku_registration (
            staff_id,
            customer_id,
            start_time,
            consultation
		)values(
            '$y->staff_id',
            '$y->customer_id',
            '$y->start_time',
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


function select_yoyaku_registration_by_id($id)
{
	global $wpdb;

    $result = $wpdb->get_results(<<<SQL
		select * from yoyaku_registration
        where id = '$id'
        order by  id
SQL
);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}

function get_last_insert_id()
{
	global $wpdb;

    $result = $wpdb->get_results(<<<SQL
		select LAST_INSERT_ID() as id from yoyaku_registration
SQL
);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);
	};
    return $result[0]->id;
}


?>