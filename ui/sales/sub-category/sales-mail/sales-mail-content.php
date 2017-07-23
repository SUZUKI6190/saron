<?php
namespace ui\sales;
use business\entity\SalesMailSetting;
use business\facade\SalesMailSettingFacade;
use business\entity\Config;

class SalesMailContent implements ISalesMailViewer
{
    const ConfirmSettingName = 'confirm_setting';
    const TitleName = 'mail_title';
    const MsgName = 'mail_msg';
    const SenderName = 'mail_send_user_name';
    const SenderAddressName = 'mail_send_user_address_name';

    public function init()
    {
    }

    public function save()
    {
        if(isset($_POST[SalesMailContext::ContentID])){
            if($_POST[SalesMailContext::ContentID] == 'save'){
                $c = Config::get_instance();
                $c->SalesMailTitle->save_value($_POST[self::TitleName]);
                $c->SalesMailMessage->save_value($_POST[self::MsgName]);
                $c->SalesMailUserName->save_value($_POST[self::SenderName]);
                $c->SalesMailUserAddress->save_value($_POST[self::SenderAddressName]);
            }
        }
    }

    public function view()
    {
        $c = Config::get_instance();
        $title = $c->SalesMailTitle->get_value();
        $msg = $c->SalesMailMessage->get_value();
        $user = $c->SalesMailUserName->get_value();
        $user_address = $c->SalesMailUserAddress->get_value();
?>
    <div class='mail_setting_wrap'>
        <div class='setting_confirm_btn_area'>
            <button class='manage_button' type='submit' name='<?php echo SalesMailContext::ContentID; ?>' value='save'>保存</button>
        </div>
        <div class = 'line'>
            <h2>メール送信者名</h2>
            <input type='text' name='<?php echo self::SenderName; ?>' value='<?php echo $user; ?>'>
        </div>
        <div class = 'line'>
            <h2>メール送信者メールアドレス</h2>
            <input type='email' name='<?php echo self::SenderAddressName; ?>' value='<?php echo $user_address; ?>'>
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