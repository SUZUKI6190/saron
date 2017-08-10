<?php
namespace ui\staff;
use business\entity\YoyakuRegistration;
use business\entity\Reserved;

abstract class FlowYoyakuBase extends FlowBase
{
    public function __construct()
    {
        $fc = FlowYoyakuContext::get_instance();
        $fc->init();
    }

    protected function save_inner()
    {
        if(!isset($_POST[StaffContext::update_schedule_btn_name])){
            return;
        }

		$fc = FlowYoyakuContext::get_instance();
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
        }
    }

    private function create_yoyaku_registration() : YoyakuRegistration
    {
        $fc = FlowYoyakuContext::get_instance();

        $customr_id = $fc->customer_id->get_value();
        $customer = \business\facade\SelectCustomerById($customr_id);
        
        $visit_num = $customer->number_of_visit;

        $yj = new YoyakuRegistration();

        $yj->staff_id = $this->_staff_id;

        $yj->customer_id = $customr_id;

        $d = new \DateTime($fc->yoyaku_date->get_value()." ".$fc->yoyaku_time->get_value());

        $datetime = $d->format('Y/m/d H:i:s');

        
        $yj->start_time = $datetime;
       
        $yj->consultation = '';

        $yj->number_of_visit = $visit_num + 1;

        return $yj;
    }


}

?>