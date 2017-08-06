<?php
namespace ui\staff;

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
            foreach($fc->course_id_list->get_value() as $c)
            {

            }
        }
    
    }

}

?>