<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

class TimingCriteriaSetting extends SettingForm
{
    private $_birth, $_last_visit, $_next_visit;
    const Key = "TimingKey";
    protected function init_inner()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_last_visit = new DayCriteriaForm($param->last_visit->get_key(), $this->_default_msg->last_visit);
		$this->_next_visit = new DayCriteriaForm($param->next_visit->get_key(), $this->_default_msg->next_visit);
        $this->_birth= new DayCriteriaForm($param->birth->get_key(), $this->_default_msg->birth);
    }

    protected function get_title() : string
    {
        return "メッセージ配信のタイミング";
    }

    protected  function get_page_id() : string
    {
        return self::Key;
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            誕生日の
            </h2>
            <?php $this->_birth->view(); ?>
        </div>
        <div class="line">
            <h2>
            最終来店日の
            </h2>
            <?php $this->_last_visit->view(); ?>
        </div>
        <div class="line">
            <h2>
            次回来店予定日の
            </h2>
            <?php $this->_next_visit->view(); ?>
        </div>
    <?php
    }

    protected function save_post_param()
    {
        SendMessageContext::get_instance()->set_send_criteria();
    }

}

?>