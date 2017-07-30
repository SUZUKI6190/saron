<?php
namespace business\entity;

class Reserved
{
	public $id;
	public $course_id;
    public $registration_id;
	public static function CreateFromWpdb($wpdb) : self
	{
		$ret = new self();
		$ret->id = $wpdb->id;
		$ret->course_id = $wpdb->course_id;
        $ret->registration_id = $wpdb->registration_id;
		return $ret;
	}
}

?>