<?php
namespace ui\send_message\sub_category;
use ui\send_message\SendMessageContext;
use ui\send_message\Param;

abstract class Criteria
{
    public $name, $default_msg;
    private $_param;
    protected abstract function init_inner();
    public abstract function view();
    
    public abstract function get_title():string;
    public abstract function get_context_param():param;
    
    public function init()
    {
        $this->_param = $this->get_context_param();
        $this->init_inner();
    }

    public function get_param():Param
    {
        return $this->_param;
    }

    public function get_hidden_id():string
    {
        return $this->name."_hdn";
    }

    public function is_set_criteria():bool
    {
        return isset($_POST[$this->get_hidden_id()]);
    }

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

    public function is_hidden():bool
    {
        return !$this->get_context_param()->is_set();
    }
}


?>