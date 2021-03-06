<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;
use business\entity\Reserved;
use business\entity\Schedule;
use business\entity\StaffSchedule;
use business\entity\Customer;

abstract class FlowYoyakuBase extends FlowBase
{
    private $_course_list;
    private $_selected_customer;
    
    protected function save_inner()
    {
        if(!isset($_POST[StaffContext::update_btn_name])){
            return;
        }

        $fc = FlowYoyakuContext::get_instance();
        
        $customr_id = $fc->customer_id->get_value();
        $this->_selected_customer = \business\facade\SelectCustomerById($customr_id);

        if($this->_flow_id == StaffContext::EditYoyakuID){
            $this->save_edit();
        }else{
            $this->save_new();
        }
    }

    private function save_edit()
    {
        $fc = FlowYoyakuContext::get_instance();
        $s = $fc->create_input_scheule_data();
    
        $s->name = $this->create_schedule_name($this->_selected_customer);

        \business\facade\StaffScheduleFacade::update($s);
    }

    private function save_new()
    {
        $fc = FlowYoyakuContext::get_instance();

        $this->_course_list = \business\facade\get_menu_course_by_idlist($fc->course_id_list->get_value());

		$list_key = $fc->course_id_list->get_key();
        
        if($fc->course_id_list->is_set()){

            $yoyaku_regist = $this->create_yoyaku_registration();

            \business\facade\insert_yoyaku_registration($yoyaku_regist);

            $regist_id = \business\facade\get_last_insert_id();
            foreach($fc->course_id_list->get_value() as $c)
            {
                $new_data = new Reserved();
                $new_data->registration_id= $regist_id;
                $new_data->course_id = $c;
                \business\facade\insert_reserved($new_data);
            }

            $schedule = $this->create_schedule();
            $schedule->extend_data = $regist_id;
            \business\facade\insert_schedule($schedule);
        }

    }

    private function create_schedule_name(Customer $c) : string
    {
        return $c->name_kanji."様 予約";
    }

    private function create_yoyaku_registration() : YoyakuRegistration
    {
        $fc = FlowYoyakuContext::get_instance();

        $customr_id = $fc->customer_id->get_value();
        
        $visit_num = $this->_selected_customer->number_of_visit;

        $yj = new YoyakuRegistration();

        $yj->staff_id = $this->_staff_id;

        $yj->customer_id = $customr_id;
        
        $yj->start_time = $this->create_start_time();
       
        $yj->consultation = $fc->consultation->get_value();;

        $yj->number_of_visit = $visit_num + 1;

        return $yj;
    }

    private function create_start_time() : string
    {
        $fc = FlowYoyakuContext::get_instance();
        $d = new \DateTime($fc->yoyaku_date->get_value()." ".$fc->yoyaku_time->get_value());
        return $d->format('Y/m/d H:i:s');
    }

    private function create_schedule() : Schedule
    {
        $fc = FlowYoyakuContext::get_instance();

        $ret = new Schedule();  
      
        $ret->staff_id = $this->_staff_id;

        $ret->start_time = $this->create_start_time();

        $ret->schedule_division = Schedule::Yoyaku;

        $sum_time = 0;
        $name = "";

        foreach($this->_course_list as $c)
        {
            $sum_time = $sum_time + $c->time_required;
            $name = $c->name."<br>";
        }

        $ret->minutes = $sum_time;

        $ret->name = $this->create_schedule_name($this->_selected_customer);

        return $ret;
    }


}

?>