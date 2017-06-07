<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class CustomerCriteriaSetting extends CriteriaForm
{
    protected function get_title() : string
    {
        return "お客様の絞り込み";
    }
 
}


?>