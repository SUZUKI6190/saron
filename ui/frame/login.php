<?php
namespace ui\frame;
use \ui\frame\ManageFrameContext;

class Login{
    const LoginPasswordKey = 'LoginPass';
	const LoginUserKey = 'LoginUser';
    const LoginSessionId = "loginsession";
    const FormName = "form";
    const SendBtnName = 'send_btn';

    public static function init()
    {
		session_start();
		$mc = ManageFrameContext::get_instance();
        
        if(self::is_send_click())
        {
            $name = self::get_user_name();
            $pass = self::get_password();
            if(\business\facade\check_login_password($name, $pass)){
                
                $mc->set_login_flg();
            }
        }
    }

    private static function is_send_click():bool
    {
        return isset($_POST[self::SendBtnName]);
    }

    private static function get_user_name() : string
    {
        return $_POST[self::LoginUserKey];
    }

    private static function get_password() : string
    {
        return $_POST[self::LoginPasswordKey];
    }

    public static function view(){
        $css_url = plugins_url("../../css" , __FILE__);
        $js_url = plugins_url("../../js" , __FILE__);
        $cssvar = '0.2';
        $d = "?date=".(new \DateTime())->format("Ymdhis");
		
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
        <head>
        <title>管理システムログイン画面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-store" />
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
        <link rel="stylesheet" href="<?php echo $css_url."/login.css?ver=$cssvar"; ?>"  type="text/css" />
        <meta name="format-detection" content="telephone=no"/>
        <meta name="msapplication-config" content="none"/>
        </head>
        <body>
        <fieldset>
            <h1>Login</h1>
            <form method='post' action='<?php echo "$d" ?>' name='<?php echo self::FormName; ?>'>
            <div class="iconUser"></div>
                <input type="text" placeholder="Username" name='<?php echo self::LoginUserKey; ?>' required>
                <div class="iconPassword"></div>
                <input type="password" placeholder="Password" name='<?php echo self::LoginPasswordKey; ?>' required>
                <input type="submit" value="Enter" name='<?php echo self::SendBtnName; ?>'>
            </form>
            </fieldset>
        </body>
        <?php
    }

}
