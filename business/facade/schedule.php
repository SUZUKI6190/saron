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
			comment,
			extend_data
		)values(
			'$s->staff_id',
			'$s->start_time',
			'$s->minutes',
			'$s->schedule_division',
			'$s->name',
			'$s->comment',
			'$s->extend_data'
		)
SQL
);
}

function update_schedule(Schedule $s)
{
	global $wpdb;
	$s = <<<SQL
		update yoyaku_schedule  set
			start_time = '$s->start_time',
			minutes = '$s->minutes',
			name = '$s->name',
			comment = '$s->comment'
		where id = '$s->id'
SQL;

	$wpdb->query($s);
}

function delete_schedule_by_id($id)
{
	global $wpdb;
	$s = <<<SQL
		delete from yoyaku_schedule
		where id = '$id'
SQL;

	$wpdb->query($s);
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


function get_schedule_by_id($id) : Schedule
{
	global $wpdb;
	$strSql = <<<SQL
		select * from yoyaku_schedule
		where id = '$id'
		order by id
SQL;

	$result = $wpdb->get_results($strSql);
	return Schedule::CreateObjectFromWpdb($result[0]);
}



?>