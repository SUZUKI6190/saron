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
		$fc = FlowYoyakuContext::get_instance();
		$list_key = $fc->course_id_list->get_key();
		if(isset($_POST[$list_key])){
			$selected_course_id_list = $_POST[$list_key];
			foreach($selected_course_id_list as $c)
			{

			}
		}
    }

}

?>