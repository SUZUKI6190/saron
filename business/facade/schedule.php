<?php
namespace business\facade;
use business\entity\Schedule;

function insert_schedule(Schedule $s)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_schedule (
			staff_id,
			start_time,
			minutes,
			schedule_division,
			name,
			data
		)values(
			'$s->staff_id',
			'$s->start_time',
			'$s->minutes',
			'$s->schedule_division',
			'$s->name',
			'$s->data'
		)
SQL
);
}


function get_schedule_by_staffid($id) : array
{
	global $wpdb;
	$strSql = <<<SQL
		select * from yoyaku_schedule
		where staff_id = '$id'
		order by id
SQL;

	$result = $wpdb->get_results($strSql);

	
    $convert = function($data)
	{
		return Schedule::CreateObjectFromWpdb($data);;
	};

    return array_map($convert, $result);
}


?>