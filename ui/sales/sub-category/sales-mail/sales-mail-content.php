<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;
use business\entity\Config;

class SalesMailContent implements ISalesMailViewer
{
    const ConfirmSettingName = 'confirm_setting';
    const TitleName = 'mail_title';
    const MsgName = 'mail_msg';
    public function init()
    {
    }

    public function save()
    {
        if(isset($_POST[self::ConfirmSettingName])){
            $c = Config::get_instance();
            $title = $c->SalesMailTitle->save_value($_POST[self::TitleName]);
            $msg = $c->SalesMailMessage->save_value($_POST[self::MsgName]);
        }
    }

    public function view()
    {
        $c = Config::get_instance();
        $title = $c->SalesMailTitle->get_value();
        $msg = $c->SalesMailMessage->get_value();
?>
    <div class='mail_setting_wrap'>
        <div class='setting_confirm_btn_area'>
            <button class='manage_button' type='submit' name='<?php echo self::ConfirmSettingName; ?>'>保存</button>
        </div>
        <div class = 'line'>
            <h2>メールタイトル</h2>
            <input type='text' name='<?php echo self::TitleName; ?>' value='<?php echo $title; ?>'>
        </div>    
        <div class = 'line'>
            <h2>メッセージ</h2>
            <textarea name='<?php echo self::MsgName; ?>'><?php echo $msg; ?></textarea>
        </div>
    </div>
<?php
    }
}

?>