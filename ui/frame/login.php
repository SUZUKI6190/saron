<?php
$css_url = plugins_url("../../css" , __FILE__);
$js_url = plugins_url("../../js" , __FILE__);
$cssvar = '0.2';
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
    <form>
      <div class="iconUser"></div>
        <input type="text" placeholder="Username" required>
        <div class="iconPassword"></div>
        <input type="password" placeholder="Password" required>
        <input type="submit" value="Enter">
    </form>
    </fieldset>
</body>
