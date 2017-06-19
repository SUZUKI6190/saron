<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;

class ScheduleTableParam
{
    public $minites_len;
    public $start_time;
    public $staff_name;
    public $schedule_name;
    public $customer_name;
    
    private static function get_minutes(\DateTime $d) : int
    {
        $hours = (int)$d->format('H');
        $minites = (int)$d->format('i');
        return ($hours * 60) + $minites; 
    }

    public static function create_from_yoyaku(YoyakuRegistration $y) : self
    {
        $ret = new self();
        $name;
        $sum_time = 0;

        $ret->start_time = self::get_minutes(new \DateTime($y->start_time)) - self::get_minutes(new \DateTime('9:00'));

        $course_list = \business\facade\get_menu_course_by_idlist($y->course_id_list);

        foreach($course_list as $c)
        {
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->schedule_name = $name;
        $ret->minites_len = $sum_time;

        $customer = \business\facade\SelectCustomerById($y->customer_id);
        $ret->customer_name = $customer->name_kanji_last;

        return $ret;
    }
}

?>