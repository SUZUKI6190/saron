<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/../page-move-button.php');
require_once(dirname(__FILE__).'/send-mail-form.php');
use business\entity\SendMessage;
use ui\send_message\SendMessageContext;
use ui\util\InputBase;
use \ui\util\SubmitButton;
use ui\util\InputTextarea;
use ui\util\RouteSelect;
use ui\ViewStaff;

abstract class Criteria
{
    public $name;
    public abstract function view();
    public abstract function is_hidden():bool;
}

abstract class CriteriaForm extends SettingForm
{
    protected abstract function create_criteria_form();
    protected function view_inner()
    {
        foreach($this->create_criteria_form() as $c)
        {
            $area_id = $c->name."_area";
            $btn_id = $c->name."_btn";
            $open_text = "指定しない";
            $close_text = "入力する";

            if($c->is_hidden()){
                $text = $close_text;
            }else{
                $text =  $open_text;
            }

            $script = "toggle_show(\"$opem_text\", \"$close_text\",\"$area_id\");";
            $btn = "<button id='$btn_id' onclick='$script' >$text</button>";
            echo $btn;
            ?>
            <div class='' id='<?php echo $area_id; ?>'>
                <?php                    
                    $c->view();
                ?>
            </div>
            <?php
        }
    }
}


?>