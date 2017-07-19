<?php
namespace ui\sales;
use business\entity\SalesMail;
use ui\sales\ISalesMailViewer;

abstract class SalesMailEditorBase implements ISalesMailViewer
{
    const MailName = "input_mail_name";

    protected abstract function init_inner();
    protected abstract function save_inner(SalesMail $data);
    protected abstract function get_mail():SalesMail;

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
        $this->save_inner($this->create_mail_data());
    }
    
    private function create_mail_data() : SalesMail
    {
        $ret = new SalesMail();
        $ret->email = $_POST[self::MailName];
        $sc = SalesContext::get_instance();
        $ret->id = $sc->sales_mail_context->get_edit_sales_id();
        return $ret;
    }

    public function view()
    {
        $m = $this->get_mail();
        $smc = (SalesContext::get_instance())->sales_mail_context;
        $id = $smc->get_edit_sales_id();
        ?>
        <div class='edit_wrap'>
            <div class='edit_confitm_area'>
                <button class='manage_button' type='submit' name='<?php echo $this->get_page_id();?>' >確定する</button>
            </div>
            <div class='edit_input_area'>
                <span>登録するメールアドレス：</span><br>
                <input type='email' name='<?php echo self::MailName; ?>' value='<?php echo $m->email ?>' >
            </div>
        </div>
        <?php
    }

}
?>