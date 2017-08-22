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
	yrs.course_id as course_id,
    yr.customer_id as customer_id
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
        $ret->start_time = new \DateTime($result[0]->start_time);
        $ret->consultation = $result[0]->consultation;
        $ret->customer_id = $result[0]->customer_id;
        foreach($result as $r)
        {
            $ret->course_id_list[] = $r->course_id;
        }
        
		return $ret;
    }

    public static function update(StaffSchedule $s)
    {
        global $wpdb;

        $strSql = <<<SQL
        select extend_data from yoyaku_schedule where id = '$s->schedule_id'
SQL;

		$registlation_id = $wpdb->get_results($strSql)[0]->extend_data;

        $strSql = <<<SQL
        UPDATE yoyaku_schedule SET
            start_time = '$s->start_time',
            comment = '$s->comment',
            name = '$s->name'
        where yoyaku_schedule.id = '$s->schedule_id'
SQL;

        $wpdb->query($strSql);

        $strSql = <<<SQL
        UPDATE yoyaku_registration SET
            start_time = '$s->start_time',
            consultation = '$s->consultation',
            customer_id = '$s->customer_id'
        where id = '$registlation_id'
SQL;

        $wpdb->query($strSql);

        $strSql = <<<SQL
        delete from yoyaku_reserved
        where registration_id = '$registlation_id'
SQL;

        $wpdb->query($strSql);

        foreach($s->course_id_list as $course_id){

            $strSql = <<<SQL
            insert into yoyaku_reserved (
                registration_id,
                course_id
            )values(
                '$registlation_id',
                '$course_id'
            )
SQL;
            $wpdb->query($strSql);
        }
	    

    }

}

?>