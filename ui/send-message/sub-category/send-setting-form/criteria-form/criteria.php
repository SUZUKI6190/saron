<?php
namespace ui\send_message\sub_category;

abstract class Criteria
{
    public $name, $default_msg;
    public abstract function init();
    public abstract function view();
    public abstract function is_hidden():bool;
    public abstract function get_title():string;
}


?>