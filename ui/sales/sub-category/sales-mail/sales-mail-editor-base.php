<?php
namespace ui\sales;
use business\entity\SalesMail;

abstract class SalesMailEditorBase
{
    const MailName = "input_mail_name";
    public abstract function init();
    protected abstract function save_inner(SalesMail $data);
    protected abstract function get_mail():SalesMail;

    public function save()
    {
        $this->save_inner($this->create_mail_data());
    }

    private function create_mail_data() : SalesMail
    {
        $ret = new SalesMail();
        $ret->email = $_POST[self::MailName];
        return $ret;
    }

    public function view()
    {
        $m = $this->get_mail();

        ?>
        <input type='email' name='<?php echo self::MailName; ?>' value='<?php echo $m->email ?>' >
        <?php
    }

}
?>