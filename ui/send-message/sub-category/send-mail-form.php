<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;

abstract class SettingForm
{
    protected $_form_id = "msg_setting_input_form";
    protected $_default_msg;

    const SendMailSettingKey = "SenddingMailState";
    const CustomerKey = "CustomerKey";
    const TimingKey = "TimingKey";

    public function set_msg(SendMessage $msg)
    {
        $this->_default_msg = $msg;
    }

    public function init()
    {
        $this->save_post_param();
    }

    public function view()
    {?>
    <form id='<?php echo $this->_form_id; ?>' name="setting" method="post">
        <div class='page_title_area'>
        <?php $this->get_title(); ?>
        </div>
        <div class='input_area'>
        <?php $this->view_inner(); ?>
        </div>
    </form>
    <?php
    }

    protected abstract function view_inner();
    protected abstract function get_title() : string;
    protected abstract function save_post_param();
}

class ContentSetting extends SettingForm
{
    private $_message;

    public function __construct()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_message = new InputTextarea($param->message->get_key(), $this->_default_msg->message_text);
    }

    protected function get_title() : string
    {
        return "メール内容設定";
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            メッセージ内容
            </h2>
            <div class="">
                <?php $this->_message->view(); ?>
            </div>
        </div>
    <?php
    }

    protected function save_post_param()
    {

    }
}

class SendCriteriaSetting extends SettingForm
{

    protected function get_title() : string
    {
        return "メッセージ配信のタイミング";
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            メッセージ内容
            </h2>
            <div class="">
                <?php $this->_message->view(); ?>
            </div>
        </div>
    <?php
    }

    protected function save_post_param()
    {

    }

}

class CustomerCriteriaSetting extends SettingForm
{

    protected function get_title() : string
    {
        return "お客様の絞り込み";
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            メッセージ内容
            </h2>
            <div class="">
                <?php $this->_message->view(); ?>
            </div>
        </div>
    <?php
    }

    protected function save_post_param()
    {

    }

}


?>