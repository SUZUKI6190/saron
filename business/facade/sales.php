<?php
namespace business\facade;
use \business\entity\Seles;

function get_sales_byday($from_day, $to_day)
{
	$strSql = <<<SQL
		select
			*
		from
			sales
		where day >= '$to_day'
		  and day <= '$from_day'
SQL;

	global $wpdb;
	$result = $wpdb->get_results($strSql);
	$ret = array_values(array_map(function($data) {
		return Sales::CreateFromWpdb($data);
	}
	return $ret;
}

function delete_sales($from_day, $to_day)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		delete from sales
		where day >= '$to_day'
		  and day <= '$from_day'
SQL
);
}

function insert_sales($sales)
{
	global $wpdb;
	$wpdb->query(
		<<<SQL
		insert into staff (
			day,
			amount_of_sales,
			per_customer_price,
			number_of_customers_new,
			number_of_customers_repeater
		)values(
			'$sales->day',
			'$sales->amount_of_sales',
			'$sales->per_customer_price',
			'$sales->number_of_customers_new',
			'$sales->number_of_customers_repeater'
		)
SQL
);
}

?>