<?php
namespace business\facade;
use \business\entity\WeeklyYoyaku;

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

?>