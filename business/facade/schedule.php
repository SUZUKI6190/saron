<?php
namespace business\facade;
use \business\entity\WeeklyYoyaku;
//use \business\entity\YoyakuTable;

function get_weekly_data() : array
{
	$strSql = <<<SQL
		select
			*
		from
			weekly_yoyaku
		order by week_kbn
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = [];
	foreach($result as $r)
	{
		$value = WeeklyYoyaku::CreateObjectFromWpdb($r);
		$key = $value->week_kbn;
		$ret[$key] = $value;
	}
	return $ret;
}

function delete_weekly_data_all()
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from weekly_yoyaku
SQL
);
}

function insert_weekly_data($w)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into weekly_yoyaku (
			from_time,
			to_time,
			is_regular_holiday,
			week_kbn
		)values(
			'$w->from_time',
			'$w->to_time',
			'$w->is_regular_holiday',
			'$w->week_kbn'
		)
SQL
);
}

/*
function get_yoyaku_table_by_staffid(string $id) : array
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		select * from yoyaku_table
		where staff_id = '$id'
SQL
);
}

function delete_yoyaku_table_by_staffid(string $id) : array
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from yoyaku_table
		where staff_id = '$id'
SQL
);
}

function insert_yoyaku_table($t)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into yoyaku_table (
			staff_id,
			yoyaku_date
		)values(
			'$w->staff_id',
			'$w->yoyaku_date'
		)
SQL
);
}
*/

?>