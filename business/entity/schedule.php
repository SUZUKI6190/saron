<?php
namespace business\entity;

class WeeklyYoyaku
{
	public $id;
	public $from_time;
	public $to_time;
	public $is_regular_holiday;
	public $week_kbn;
	
	const SunKbn = 0;
	const MonKbn = 1;
	const TueKbn = 2;
	const WedKbn = 3;
	const ThuKbn = 4;
	const FriKbn = 5;
	const SatKbn = 6;
	
	public function get_week_char():string
	{
		switch($this->week_kbn)
		{
			case self::SunKbn:
				return '日';
				break;
			case self::MonKbn:
				return '月';
				break;
			case self::TueKbn:
				return '火';
				break;
			case self::WedKbn:
				return '水';
				break;
			case self::ThuKbn:
				return '木';
				break;
			case self::FriKbn:
				return '金';
				break;
			case self::SatKbn:
				return '土';
				break;
			default:
				break;
		}
	}

	public static function CreateObjectFromWpdb($wpdb) : WeeklyYoyaku
	{
		$ret = new WeeklyYoyaku();
		
		$ret->from_time = $wpdb->from_time;
		$ret->to_time = $wpdb->to_time;
		$ret->is_regular_holiday = $wpdb->is_regular_holiday;
		$ret->week_kbn = $wpdb->week_kbn;	
		return $ret;
	}
}

?>