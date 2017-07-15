<?php

namespace business\facade;

use business\entity\YoyakuRegistration;

function get_group_yoyaku_registration($list)
{
    $group = [];

    foreach($list as $yr)
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


function get_day_group_yoyaku_registration($list)
{
    $group = [];

    foreach($list as $yr)
    {
        $d = new \DateTime($yr->start_time);
        $year = ($d)->format('Y');
        $month =(int)($d)->format('m');
        $day =(int)($d)->format('d');
        $lastdate = new \DateTime(date('Y-m-d',        //日付の形式 Y：年(西暦4桁)、m：月(01～12)、d：日(01～31)
                                        mktime(0,       //時
                                                0,       //分
                                                0,       //秒
                                                $month+1,  //月(翌月)
                                                0,       //日(0を指定すると前月の末日)
                                                $year    //年
                                            )));

        $day_conut = 1;
        $group[$year] = [];
        $max_day = (int)$lastdate->format("d");
        while($day_conut <= $max_day)
        {
            if($day_conut == $day){
                $group[$year][$day_conut][] = $yr;
            }else{
                $group[$year][$day_conut] = [];
            }
            $day_conut++;
        }
    }

    return $group;
}

function get_yoyaku_registration_by_date_between(\DateTime $from_date, \DateTime $to_date) : array
{
    global $wpdb;
    $f = $from_date->format('Ymd');
    $to = $to_date->format('Ymd');
    $strSql = <<<SQL
SELECT * FROM `yoyaku_registration`
WHERE start_time >= '$f'
  and start_time <= '$to'
  ORDER BY start_time ASC
SQL;

    $result = $wpdb->get_results($strSql);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}

function get_yoyaku_registration_last_3_years_by_month(int $month) : array
{
    global $wpdb;
    $strSql = <<<SQL
    SELECT * from yoyaku_registration
    WHERE  YEAR(start_time) BETWEEN YEAR(NOW()) - 2 AND YEAR(NOW())
    AND MONTH(start_time) = '$month'
    ORDER BY start_time ASC
SQL;

    $result = $wpdb->get_results($strSql);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    $list = array_map($convert, $result);

    return get_day_group_yoyaku_registration($list);
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

    $list = array_map($convert, $result);

    return get_group_yoyaku_registration($list);
}

function get_yoyaku_registration_last_month() : array
{
    global $wpdb;
    $strSql = <<<SQL
    SELECT * from yoyaku_registration
        WHERE  Month(start_time) BETWEEN Month(NOW()) - 2 AND Month(NOW())
        ORDER BY start_time ASC
SQL;

    $result = $wpdb->get_results($strSql);

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    $list = array_map($convert, $result);

    return get_group_yoyaku_registration($list);
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
            consultation,
            number_of_visit
		)values(
            '$y->staff_id',
            '$y->customer_id',
            '$y->start_time',
            '$y->consultation',
            '$y->number_of_visit'
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



function get_yoyaku_registration_by_ym(\DateTime $date) : array
{
    global $wpdb;
    $str_year = $date->format('Y');
    $str_month = $date->format('m');
    $strSql = <<<SQL
SELECT * FROM `yoyaku_registration`
WHERE YEAR(start_time) = '$str_year'
  and MONTH(start_time) = '$str_month'
  ORDER BY start_time ASC
SQL;

    $result = $wpdb->get_results($strSql);

    $lastdate = new \DateTime(date('Y-m-d',        //日付の形式 Y：年(西暦4桁)、m：月(01～12)、d：日(01～31)
                                mktime(0,       //時
                                        0,       //分
                                        0,       //秒
                                        ((int)$str_month)+1,  //月(翌月)
                                        0,       //日(0を指定すると前月の末日)
                                         $str_year   //年
                                    )));

    $convert = function($data)
	{
		return YoyakuRegistration::CreateObjectFromWpdb($data);;
	};

    $yr_list = array_map($convert, $result);

    $day_num = (int)$lastdate->format("d");
    $day_cont = 1;
    $group = [];

    while($day_cont <= $day_num)
    {
        $sum_list = [];

        foreach($yr_list as $y)
        {
            $date = new \DateTime($y->start_time);
            $day = (int)($date->format("d"));
            if($day_cont == $day){
                $sum_list[] = $y;
            }
        }

        $group[$day_cont] = $sum_list;

        $day_cont++;
    }

    return $group;
}

?>