<?php
namespace ui\yoyaku\controll;
use \ui\util\InputControll;
use ui\yoyaku\menu\DaySelect;

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
            $name = DaySelect::DateTimeBtnName;
            echo "<button type='submit' class='yoyaku_button' name='$name' value='$this->_value'>◎</button>";
        }else{
            echo "<span class='disable_cell'>✕</span>";
        }

    }
}

?>