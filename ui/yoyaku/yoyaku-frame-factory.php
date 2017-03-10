<?php
namespace ui\yoyaku;
require_once('frame\yoyaku-frame.php');
require_once('yoyaku-menu-factory.php');
use ui\yoyaku\frame\YoyakuFrame;

function yoyaku_frame_factory() : YoyakuFrame
{
	$main = main_yoyaku_factory();
	return new YoyakuFrame($main);
}

?>