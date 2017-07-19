<?php
namespace ui\sales;
use business\entity\SalesMail;
use ui\sales\ISalesMailViewer;

abstract class SalesMailEditorBase implements ISalesMailViewer
{
    const MailName = "input_mail_name";
    const SalesIdName = 'sales_id';

    protected abstract function init_inner();
    protected abstract function save_inner(SalesMail $data);
    protected abstract function get_mail():SalesMail;
    
    protected abstract function get_text():string;

    protected function get_page_id():string
    {
        return SalesMailContext::ListID;
    }

    public function init()
    {
        $this->init_inner();
    }

    public function save()
    {
        if(isset($_POST[$this->get_page_id()])){  
            $this->save_inner($this->create_save_mail_data());
        }
    }
    
    protected function get_sales_id()
    {
        return $_POST[self::SalesIdName];
    }

    private function create_save_mail_data() : SalesMail
    {

        $ret = new SalesMail();
        $ret->email = $_POST[self::MailName];
        $sc = SalesContext::get_instance();
        $ret->id = $_POST[self::SalesIdName];
        return $ret;
    }

    public function get_edit_sales_id()
    {
        if(isset($_POST[SalesMailContext::EditID])){
            return $_POST[SalesMailContext::EditID];
        }else{
            return "";
        }
    }

    public function view()
    {
        $m = $this->get_mail();
        $smc = (SalesContext::get_instance())->sales_mail_context;
        $id = $this->get_edit_sales_id();
        ?>
        <div class='edit_wrap'>
            <div class='edit_confitm_area'>
                <button class='manage_button' type='submit' name='<?php echo $this->get_page_id();?>' >確定する</button>
            </div>
            <div class='edit_input_area'>
                <span><?php echo $this->get_text();?>：</span><br>
                <input type='email' name='<?php echo self::MailName; ?>' value='<?php echo $m->email ?>' >
            </div>
        </div>
        <input type='hidden' name='<?php echo self::SalesIdName; ?>' value='<?php echo $id; ?>'>
        <?php
    }

}
?>