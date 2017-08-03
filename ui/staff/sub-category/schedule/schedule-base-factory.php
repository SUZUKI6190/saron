<?php
namespace ui\staff;
require_once(dirname(__FILE__).'/schedule-table-param.php');
require_once(dirname(__FILE__).'/schedule-base.php');
require_once(dirname(__FILE__).'/schedule-list.php');
require_once(dirname(__FILE__).'/schedule-timetable.php');
require_once(dirname(__FILE__).'/schedule-empty.php');
require_once(dirname(__FILE__).'/edit/schedule-edit.php');

use \business\entity\Schedule;

class ScheduleBaseFactory
{
    private function __construct(){}


    public static function create_schedule_base() : ScheduleBase
    {
        if(self::is_timetable_click()){
            return new ScheduleTimeTable();
        }

        if(self::is_list_click()){
            return new ScheduleList();
        }

        if(self::is_edit_page()){
            return new ScheduleEdit();
        }

        return new ScheduleEmpty();
    }

    
    private static function is_edit_page() : bool
    {
        return isset($_POST[StaffContext::edit_page_name]) || isset($_POST[StaffContext::edit_btn_name]) || isset($_POST[StaffContext::new_btn_name]);
    }

    private static function is_update_click() : bool
    {
        return isset($_POST[StaffContext::update_btn_name]);
    }

    public static function is_timetable_click():bool
    {
        return isset($_POST[StaffContext::timetable_btn_name]) || self::is_update_click();
    }

    public static function is_list_click():bool
    {
        return isset($_POST[StaffContext::list_btn_name]);
    }

}

?>