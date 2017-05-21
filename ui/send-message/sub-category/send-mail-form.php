<?php
namespace ui\send_message\sub_category;
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;

abstract class SettingForm
{
    protected $_form_id = "msg_setting_input_form";
    protected $_default_msg;

    const SendMailSettingKey = "SenddingMailState";
    
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
    private $_sending_mail, $_confirm_mail;
    private $_title;
    public function __construct()
    {
        $required_attr = [];
		$required_attr["required"] = "";
        $param = SendMessageContext::get_instance()->get_param_set();
        $this->_title =  new InputBase("text", $param->title->get_key(), $this->_default_msg->title, "", $required_attr);
        $this->_message = new InputTextarea($param->message->get_key(), $this->_default_msg->message_text);
        $this->_sending_mail = new InputBase("email", $param->sending_mail->get_key(), $this->_default_msg->sending_mail);
		$this->_confirm_mail = new InputBase("email", $param->confirm_mail->get_key(), $this->_default_msg->confirm_mail);
    }

    protected function get_title() : string
    {
        return "メール内容設定";
    }

    protected  function get_page_id() : string
    {
        return "";
    }

    protected function view_inner()
    {
    ?>
        <div class="line">
            <h2>
            メールタイトル
            </h2>
            <?php $this->_title->view(); ?>
        </div>
        <div class="line">
            <h2>
            メッセージ内容
            </h2>
            <div class="">
                <?php $this->_message->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            送信元のメールアドレス
            </h2>
            <div class="">
                <?php $this->_sending_mail->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            送信後の確認メールアドレス
            </h2>
            <div class="">
                <?php $this->_confirm_mail->view(); ?>
            </div>
        </div>
    <?php
    }

    protected function save_post_param()
    {
        $SendMessageContext::get_instance()->get_param_set()->set_mail_content();

    }
}

class TimingCriteriaSetting extends SettingForm
{
    private $_birth, $_last_visit, $_next_visit;
    const Key = "TimingKey";
    public function __construct()
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
        SendMessageContext::get_instance()->get_param_set()->set_send_criteria();
    }

}

class CustomerCriteriaSetting extends SettingForm
{
	private $_sending_mail, $_confirm_mail;
	private $_message;
	private $_occupation;
	private $_vist_num;
	private $_reservation_route;
	private $_staff;
    const Key = "CustomerKey";

    public function __construct()
    {
        $param = SendMessageContext::get_instance()->get_param_set();
		$this->_occupation = new InputBase("text", $param->occupation->get_key(), $this->_default_msg->occupation);
		$this->_vist_num = new InputBase("number", $param->visit_num->get_key(), $this->_default_msg->visit_num);
		$this->_reservation_route = new RouteSelect();
		$this->_reservation_route->set_name($param->reservation_route->get_key());
		$this->_reservation_route->set_selected_id($this->_default_msg->reservation_route);
		$this->_staff = new ViewStaff($param->staff->get_key());
    }

    protected function get_title() : string
    {
        return "お客様の絞り込み";
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
            性別
            </h2>
            <div class=""：>

            <select name="sex" id="sex">
                <option value='None'></option>
                <option value='M'>男性</option>
                <option value='F'>女性</option>
            </select>
    
            </div>
        </div>
        
        <div class="line">
            <h2>
            職業
            </h2>
            <div class="">
                <?php $this->_occupation->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            来店回数
            </h2>
            <div class="">
                <?php $this->_vist_num->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            予約経路
            </h2>
            <div class="">
                <?php $this->_reservation_route->view(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            担当スタッフ
            </h2>
            <div class="">
                <?php $this->_staff->view_staff_select(); ?>
            </div>
        </div>
        <div class="line">
            <h2>
            DM不可を除く
            </h2>
            <div class="">
                <?php
                $param = SendMessageContext::get_instance()->get_param_set();
                $name = $param->enable_dm->get_key();
                echo "<input type='checkbox' name='$name' value='$name'>"
                ?>
            </div>
        </div>

    <?php
    }

    protected function save_post_param()
    {
        SendMessageContext::get_instance()->get_param_set()->set_customer_criteria();
    }

}


?>