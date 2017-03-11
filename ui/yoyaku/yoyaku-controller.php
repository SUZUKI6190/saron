<?php
namespace ui\yoyaku;
require_once("frame/yoyaku-frame.php");
require_once("frame/yoyaku-footer.php");
require_once("frame/yoyaku-footer.php");
require_once("yoyaku-frame-factory.php");
require_once('yoyaku-context.php');

use ui\IController;

class YoyakuController implements IController
{
	private $_manu_frame;
	public function init()
	{
		$this->_manu_frame = \ui\yoyaku\yoyaku_frame_factory();
	}

	public function view()
	{
		$this->_manu_frame->view();			
		
		exit;
	}	

}

	

?>