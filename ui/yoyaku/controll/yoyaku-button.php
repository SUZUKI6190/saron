<?php
namespace ui\yoyaku\controll;
use \ui\util\InputControll;

class YoyakuToggle
{
    public $enable_yoyaku = false;
    private $_staff_id;
    private $_value;

    public function __construct(\DateTime $d)
    {
        $this->_value= $d->format('Y-m-d H:i:s');
    }

    public function view()
    {
        if($this->enable_yoyaku){
            echo "<button type='submit' class='yoyaku_button' name='yoyaku_date_time' value='$this->_value'>◎</button>";
        }else{
            echo "<span class='disable_cell'>✕</span>";
        }

    }
}

?>