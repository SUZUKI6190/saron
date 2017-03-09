<?php
namespace ui;
require_once('controller-factory.php');
use \ui\frame;

function YoyakuManageConroll()
{
	$ctr = create_controller();
	
	$ctr->init();
	
	$ctr->view();
}

?>