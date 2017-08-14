
<?php
namespace business\facade;
use business\entity\Sold;

class SoldFacade
{
	public static function insert(Sold $r)
	{
		global $wpdb;
		$strSql = <<<SQL
insert into yoyaku_sold (
	registration_id,
	name,
	price
)values(
	'$r->registration_id',
	'$r->name',
	'$r->price'
)
SQL;
		$wpdb->query($strSql);
	}

	public static function get_by_registration_id($id) : array
	{
		$strSql = <<<SQL
select * from yoyaku_sold
where registration_id = '$id'
SQL;

		global $wpdb;
		$result = $wpdb->get_results($strSql);
		$ret = array_values(array_map(function($data) {
			return Sold::CreateFromWpdb($data);
		}, $result));
		return $ret;
	}

	public static function  delete_by_registration_id($id) 
	{
		$strSql = <<<SQL
delete from yoyaku_sold
where registration_id = '$id'
SQL;
		global $wpdb;
		$wpdb->query($strSql);
	}

}

?>