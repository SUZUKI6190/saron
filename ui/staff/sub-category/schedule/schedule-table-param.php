<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;
use business\entity\Schedule;

class ScheduleTableParam
{
    public $schedule_id;
    public $minites_len;
    public $start_datetime;
    public $start_minutes;
    public $staff_name;
    public $schedule_name;
public $schedule_division;
    public $comment;
    
    private static function get_minutes(\DateTime $d) : int
    {
        $hours = (int)$d->format('H');
        $minites = (int)$d->format('i');
        return ($hours * 60) + $minites; 
    }

    public static function create_from_schedule(Schedule $s) : self
    {
        $ret;
        if($s->schedule_division == Schedule::Yoyaku){
            $ret = self::create_from_yoyaku($s);
            $ret->schedule_division = Schedule::Yoyaku;
        }else{
            $ret = self::create_from_other($s);
            $ret->schedule_division = Schedule::Other;
        }

        return $ret;
    }

    private static function create_from_yoyaku(Schedule $s) : self
    {
        $ret = new self();
        $name = "";
        $sum_time = 0;

        $yoyaku_registration_id = $s->extend_data;
        $yoyaku = \business\facade\select_yoyaku_registration_by_id($yoyaku_registration_id)[0];

        $ret->schedule_id = $s->id;
        $ret->start_datetime = $s->start_time;
        $ret->start_minutes = self::get_minutes(new \DateTime($s->start_time)) - self::get_minutes(new \DateTime('9:00'));

        $reserved_list = \business\facade\get_reserved_by_registration_id($yoyaku->id);
        
        foreach($reserved_list as $r)
        {
            $c = \business\facade\get_menu_course_by_id($r->course_id);
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->schedule_name = $s->name;
        $ret->minites_len = $sum_time;

        $customer = \business\facade\SelectCustomerById($yoyaku->customer_id);
        
        $ret->comment = $yoyaku->consultation;

        return $ret;
    }

    private static function create_from_other(Schedule $s) : self
    {
        $ret = new self();
        $name = "";
        $sum_time = 0;

        $yoyaku_registration_id = $s->extend_data;
   
        $ret->schedule_id = $s->id;
        $ret->start_datetime = $s->start_time;
        $ret->start_minutes = self::get_minutes(new \DateTime($s->start_time)) - self::get_minutes(new \DateTime('9:00'));

        $ret->schedule_name = $s->name;
        $ret->minites_len = $s->minutes;
        $ret->comment = $s->comment;

        return $ret;
    
    }

}

?>