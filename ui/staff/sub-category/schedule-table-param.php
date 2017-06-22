<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;
use business\entity\Schedule;
use business\entity\YoyakuJson;

class ScheduleTableParam
{
    public $schedule_id;
    public $minites_len;
    public $start_datetime;
    public $start_minutes;
    public $staff_name;
    public $schedule_name;
    public $customer_name;
    
    private static function get_minutes(\DateTime $d) : int
    {
        $hours = (int)$d->format('H');
        $minites = (int)$d->format('i');
        return ($hours * 60) + $minites; 
    }

    public static function create_from_yoyaku(Schedule $s) : self
    {
        $ret = new self();
        $name = "";
        $sum_time = 0;

        $yoyaku = YoyakuJson::create_from_json($s->data);

        $ret->schedule_id = $s->id;
        $ret->start_datetime = $s->start_time;
        $ret->start_minutes = self::get_minutes(new \DateTime($s->start_time)) - self::get_minutes(new \DateTime('9:00'));

        $course_list = \business\facade\get_menu_course_by_idlist($yoyaku->course_id_list);

        foreach($course_list as $c)
        {
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->schedule_name = $s->name;
        $ret->minites_len = $s->minutes;

        $customer = \business\facade\SelectCustomerById($yoyaku->customer_id);
        $ret->customer_name = $customer->name_kanji_last;

        return $ret;
    }

}

?>