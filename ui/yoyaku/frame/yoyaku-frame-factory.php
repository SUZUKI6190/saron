<?php
namespace ui\yoyaku\frame;
require_once('yoyaku-frame.php');
require_once('yoyaku-menu-factory.php');

function yoyaku_frame_factory() : yoyakuFrame
{
	$main = main_yoyaku_factory();
	return new yoyakuFrame($main);
}

?>