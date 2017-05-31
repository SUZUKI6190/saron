<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../page-move-button.php');
require_once(dirname(__FILE__).'/criteria-form.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;


abstract class SettingForm
{
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
        $sc->update_session();
    }

    public function view()
    {
        $sc = SendMessageContext::get_instance();
		$state = $sc->save_btn_state;
        
    ?>
        <input type ='hidden' name='<?php echo SendMessageContext::PageNoKey; ?>' value='<?php echo $sc->page_no; ?>'>
        <input type ='hidden' name='<?php echo $state->get_key(); ?>' value='<?php echo $state->get_value();?>'>
        <div class='page_title_area'>
            <h1>
            <?php echo $this->get_title(); ?>
            </h1>
        </div>
        <div class='move_btn_area'>
            <div class='next_btn_area'>
                <?php
                if(!$sc->is_min_page()){
                    $this->_backBtn->view();
                }
                ?>
            </div>
            <div class='back_btn_area'>
                <?php
                if(!$sc->is_max_page()){
                    $this->_nextBtn->view();
                }
                ?>
            </div>
        </div>
        <div class=''>
            <?php $this->view_inner(); ?>
        </div>
    <?php
    }

    protected abstract function view_inner();
    protected abstract function init_inner();
    protected abstract function get_title() : string;
}
?>