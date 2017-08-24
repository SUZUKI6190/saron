<?php
namespace business\entity;

class StaffSchedule
{
	public $start_time;
	public $schedule_id;
	public $consultation;
	public $customer_id;
	public $comment;
	public $course_id_list = [];
	public $name;
	public $is_first_visit_check;
}
?>