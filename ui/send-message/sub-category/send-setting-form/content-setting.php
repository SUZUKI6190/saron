<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;


class ContentSetting extends SettingForm
{
    private $_message;
    private $_sending_mail, $_confirm_mail;
    private $_title;
    private $_send_user_name;
    protected function init_inner()
    {
        $required_attr = [];
		$required_attr["required"] = "";
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_send_user_name = new InputBase("text", $param->send_user_name->get_key(), $this->_default_msg->send_user_name, "", $required_attr);
        $this->_title =  new InputBase("text", $param->title->get_key(), $this->_default_msg->title, "", $required_attr);
        $this->_message = new InputTextarea($param->message->get_key(), $this->_default_msg->message_text);
        $this->_sending_mail = new InputBase("email", $param->sending_mail->get_key(), $this->_default_msg->sending_mail);
		$this->_confirm_mail = new InputBase("email", $param->confirm_mail->get_key(), $this->_default_msg->confirm_mail);
    }
    
    protected function get_title() : string
    {
        return "メール内容設定";
    }

    protected function view_inner()
    {
    ?>
        <div class="line title">
            <h2>
            メール送信者名
            </h2>
            <?php $this->_send_user_name->view(); ?>
        </div>
        <div class="line title">
            <h2>
            メールタイトル
            </h2>
            <?php $this->_title->view(); ?>
        </div>
        <div class="line message">
            <h2>
            メッセージ内容
            </h2>
            <div class="">
                <?php $this->_message->view(); ?>
            </div>
        </div>
        <div class="line send_mail">
            <h2>
            送信元のメールアドレス
            </h2>
            <div class="">
                <?php $this->_sending_mail->view(); ?>
            </div>
        </div>
        <div class="line confirm_mail">
            <h2>
            送信後の確認メールアドレス
            </h2>
            <div class="">
                <?php $this->_confirm_mail->view(); ?>
            </div>
        </div>
    <?php
    }

}

?>