<?php
namespace ui\staff;
use ui\staff\ScheduleBase;

class ScheduleEmpty extends ScheduleBase
{
    protected function init_inner()
    {
    }
      
    protected function view_inner()
    {

    }

    public function is_empty():bool
    {
        return true;
    }

}

?>