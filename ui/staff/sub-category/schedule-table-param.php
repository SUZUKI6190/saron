<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;

class ScheduleTableParam
{
    public $minites_len;
    public $start_time;
    public $staff_name;
    public $schedule_name;

    public static function create_from_yoyaku(string $saff_name, YoyakuRegistration $y) : self
    {
        $ret = new self();
        $ret->start_time = $y->start_time;
        $ret->saff_name = $saff_name;
        $name;
        $sum_time = 0;

        $course_list = get_menu_course_by_idlist($y->course_id_list);

        foreach($course_list as $c)
        {
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->schedule_name = $name;
        $ret->minites_len = $sum_time;
        
        return $ret;
    }
}

?>