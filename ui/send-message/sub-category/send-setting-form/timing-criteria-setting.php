<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/criteria-form/timing-criteria.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\send_message\Param;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class TimingCriteriaSetting extends CriteriaForm
{
    protected function get_title() : string
    {
        return "メッセージ配信のタイミング";
    }
}

?>