<?php
namespace ui\menu;
require_once("frame/menu-frame.php");
require_once("frame/menu-footer.php");
require_once("frame/menu-frame-factory.php");
require_once('menu-context.php');
use ui\IController;

class MenuController implements IController
{
	private $_manu_frame;
	public function init()
	{
		$this->_manu_frame = \ui\menu\frame\menu_frame_factory();
	}

	public function view()
	{
		$this->_manu_frame->view();
		?>
	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Expires" content="0" /><title></title>
		
		<link rel="stylesheet" href="<?php echo plugins_url("../css/menu/common.css", __FILE__); ?>?ver=0.01"  type="text/css" />
		<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
		<meta name="format-detection" content="telephone=no"/>
		<meta name="msapplication-config" content="none"/>
		</head>
		<body>
		<div class="main_wrap">
		<?php
			
		?>
		</div>
		<?php
			
		?>	
		<body>
		<?php
		
		exit;
	}	

}

	

?>