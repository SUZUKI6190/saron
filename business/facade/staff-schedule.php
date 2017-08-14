<?php
namespace business\facade;
use \business\entity\StaffSchedule;

class StaffScheduleFacade
{
    private function __construct(){}

    public static function get_by_schedule_id($schedule_id)
    {
        $strSql = <<<SQL
SELECT
	yr.start_time as start_time,
	ys.id as schedule_id,
    yr.consultation as consultation,
	yrs.course_id as course_id
FROM yoyaku_schedule as ys,
yoyaku_registration as yr,
yoyaku_reserved as yrs
where ys.id = '$schedule_id'
  and ys.extend_data = yr.id
  and yrs.registration_id = yr.id
SQL;

		global $wpdb;
		$result = $wpdb->get_results($strSql);

		$ret = new StaffSchedule();

        $ret->schedule_id = $result[0]->schedule_id;
        $ret->start_time = $result[0]->start_time;
        $ret->consultation = $result[0]->consultation;
        foreach($result as $r)
        {
            $ret->course_id_list[] = $result->course_id;
        }
        
		return $ret;
    }    
}

?>