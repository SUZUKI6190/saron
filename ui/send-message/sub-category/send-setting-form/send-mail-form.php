<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../page-move-button.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

abstract class SettingForm
{
    protected $_form_id = "msg_setting_input_form";
    protected $_default_msg;
    protected $_nextBtn, $_backBtn;

    const SendMailSettingKey = "SenddingMailState";

    public function set_msg(SendMessage $msg)
    {
        $this->_default_msg = $msg;
    }

    public function init()
    {
        $this->_nextBtn = new PageMoveButton(SendMessageContext::NextBtnKey, "次へ", 1);
        $this->_backBtn = new PageMoveButton(SendMessageContext::BackBtnKey, "前へ", -1);
        $sc = SendMessageContext::get_instance();
        $this->init_inner();
    }

    public function save_param()
    {
        $this->save_post_param();
    }

    public function view()
    {
        $sc = SendMessageContext::get_instance();
    ?>
    <form id='<?php echo $this->_form_id; ?>' name="setting" method="post">
        <input type ='hidden' name='<?php echo SendMessageContext::PageNoKey; ?>' value='<?php echo $sc->page_no; ?>'>
        <div class='next_button_area'>
        <?php
        $this->_backBtn->view();
        $this->_nextBtn->view();
        ?>
        </div>
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
    protected abstract function init_inner();
    protected abstract function get_title() : string;
    protected abstract function save_post_param();
    protected abstract function get_page_id() : string;
}
?>