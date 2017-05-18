<?php
namespace ui\yoyaku\controll;
use \ui\util\InputControll;

class YoyakuToggle
{
    public $enable_yoyaku = false;
    private $_staff_id;
    private $_date_time;
    private $_input;

    public function __construct(\DateTime $d)
    {
        $name= $d->format('YMdHi');
        $this->_input = new InputControll('submit', $name);
    }

    public function view()
    {
        $add_css = "";
        $atr = [];
        if($this->enable_yoyaku){
            $this->_input->set_value("◎");
            $add_css = "enable";
            $css = "yoyaku_button $add_css";
            $this->_input->set_style($css);
            $this->_input->set_attribute($atr);
            $this->_input->view();
        }else{
            echo "<span class='disable_cell'>✕</span>";
        }

    }
}

?>