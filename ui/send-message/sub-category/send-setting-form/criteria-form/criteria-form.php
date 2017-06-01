<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../../page-move-button.php');
require_once(dirname(__FILE__).'/../send-mail-form.php');
require_once(dirname(__FILE__).'/criteria.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

abstract class CriteriaForm extends SettingForm
{
    private $_criteria_list;
    protected abstract function create_criteria_form();

    protected function init_inner()
    {
        $this->_criteria_list = $this->create_criteria_form();
        foreach($this->_criteria_list as $c)
        {
            $c->default_msg = $this->_default_msg;
            $c->init();
        }
        $sc = SendMessageContext::get_instance();       
        $sc->enable_save_btn();
    }

    protected function view_inner()
    {
        foreach($this->_criteria_list as $c)
        {
            $area_id = $c->name."_area";
            $btn_id = $c->name."_btn";
            $hdn_id = $c->name."_hdn";
            $open_text = "指定しない";
            $close_text = "入力する";
            $hdn_value;

            if($c->is_hidden()){
                $text = $open_text;
                $hdn_value = "false";
            }else{
                $text =  $close_text;
                $hdn_value = "true";
            }

            $script = "toggle_show(\"$open_text\", \"$close_text\",\"$area_id\", \"$btn_id\" , \"$hdn_id\", \"$c->name\");";
            ?>
            <div class='criteria_wrap'>
                <div class="line">
                    <h2>
                        <?php echo $c->get_title(); ?>
                    </h2>
                    <?php
                    $btn = "<button class='manage_button' type='button' id='$btn_id' onclick='$script' >$text</button>";
                    echo $btn;
                    ?>
                    <div class='critera_input_area' disabled="disabled" id='<?php echo $area_id; ?>' value='<?php echo $hdn_value; ?>'>
                        <?php                    
                            $c->view();
                        ?>
                        <input type='hidden' id='<?php echo $hdn_id; ?>' value='<?php echo $hdn_value; ?>'>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}


?>