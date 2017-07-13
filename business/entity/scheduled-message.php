<?php
namespace business\entity;

class ScheduledMessage
{
    public $text;
    public $title;
    public $email;
    
	public static function CreateObjectFromWpdb($db) : self
	{
		$result = new self;
        $result->text = $db->text;
        $result->title = $db->title;
        $result->email = $db->email;
		return $result;
	}
}
?>