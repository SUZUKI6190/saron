<?php
namespace ui\yoyaku\controll;
use \ui\util\InputControll;
class YoyakuToggle
{
    private $_state = false;
    private $_staff_id;
    private $_date_time;
    private $_input;

    public function __construct(\DateTime $d)
    {
        $name= $d->format('YMdHi');
        $this->_input = new InputControll('button', $name);
    }

    public function save()
    {
        if($this->_input->is_submit())
        {

        }
    }

    public function view()
    {
        $this->_input->view();
    }
}

?>