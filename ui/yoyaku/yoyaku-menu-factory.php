<?php
namespace ui\yoyaku;
require_once('menu/yoyaku-select.php');
require_once('frame/yoyaku-frame.php');

use ui\yoyaku\YoyakuContext;
use ui\yoyaku\menu\YoyakuSelect;

function main_yoyaku_factory() : \ui\yoyaku\frame\YoyakuMenu
{
	$contxt = YoyakuContext::get_instance();
	return new YoyakuSelect();
}
?>