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
    protected abstract function on_set_criteria(Criteria $c);
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
            $area_css;
            $btn_id = $c->name."_btn";
            $hdn_id = $c->get_hidden_id();
            $hdn_value;
            $open_text = "指定しない";
            $close_text = "入力する";
            $hdn_value;
            $disabled;

            if($c->is_hidden()){
                $text = $close_text;
                $area_css = "critera_input_area hide";
                $hdn_value = 0;
            }else{
                $text =  $open_text;
                $area_css = "critera_input_area";
                $hdn_value = 1;
            }

            $script = "toggle_show(\"$open_text\", \"$close_text\",\"$area_id\", \"$btn_id\" , \"$c->name\", \"$hdn_id\");";
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
                    <div class='<?php echo $area_css; ?>' id='<?php echo $area_id; ?>' value='<?php echo $hdn_value; ?>'>
                        <?php                    
                            $c->view();
                        ?>
                    </div>
                </div>
                <?php echo "<input type='hidden' name='$hdn_id' id='$hdn_id' value='$hdn_value />"; ?>
            </div>
            <?php
        }
    }
}


?>