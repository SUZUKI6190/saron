<?php
namespace ui\send_message\sub_category;

use \ui\util\SubmitButton;
use ui\send_message\SendMessageContext;

class PageMoveButton
{
    private $_btn;
    private $_name;
    private $_add_value;
    private $_text;
    public function __construct(string $name, string $text, int $add)
    {
        $this->_name = $name;
        $this->_add_value = $add;
        $this->_text = $text;
        $this->_btn = new SubmitButton($this->_name, $this->_text);
    }

    public function page_move()
    {

    }
    
    public function view()
    {
        $this->_btn->view();
    }
}

?>