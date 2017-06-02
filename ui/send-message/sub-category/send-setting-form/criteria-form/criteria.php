<?php
namespace ui\send_message\sub_category;

abstract class Criteria
{
    public $name, $default_msg;
    public abstract function init();
    public abstract function view();
    public abstract function is_hidden():bool;
    public abstract function get_title():string;
    
    protected function view_radio($name, $selected_name, $d)
    {
        foreach($d as $key => $text)
        {
            
            if($key  == $selected_name){
                echo "<input type='radio' name='$name' value='$key' checked>$text";
            }else{
                echo "<input type='radio' name='$name' value='$key'>$text";
            }
        }
    }

}


?>