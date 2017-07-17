<?php
namespace ui\sales;
use business\entity\SalesMail;
use ui\sales\ISalesMailViewer;

abstract class SalesMailEditorBase implements ISalesMailViewer
{
    const MailName = "input_mail_name";
    const ConfirmName = "confirm_btn";
    protected abstract function init_inner();
    protected abstract function save_inner(SalesMail $data);
    protected abstract function get_mail():SalesMail;

    public function init()
    {
        $this->init_inner();
    }

    public function save()
    {
        if($this->is_confirm()){
            $this->save_inner($this->create_mail_data());
        }     
    }

    private function is_confirm():bool
    {
        return isset($_POST[self::ConfirmName]);
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
        <input type='email' name='<?php echo self::MailName; ?>' value='<?php echo $m->email ?>' >
        <button class='manage_button' type='submit' name='<?php echo self::ConfirmName; ?>' >確定する</button>
        <input type='hidden' name='<?php echo SalesMailContext::EditBtnName;?>' value='<?php echo $id; ?>'>
        </div>
        <?php
    }

}
?>