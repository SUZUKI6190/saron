<?php
namespace ui\staff;

class StaffContext
{

	const list_btn_name = "list_btn";
    const timetable_btn_name = "time_table_btn";
    const edit_page_name = 'edit_page_name';
    const new_btn_name = 'new_schedule_btn';
    const edit_btn_name = "edit_btn";
	const update_btn_name = "update_btn";

	private static $_instance;
	private function __construct()
	{
	}

	public $staff_id;
	
	public static function get_instance() : StaffContext
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new StaffContext();
		}
		return self::$_instance;
	}
}

?>