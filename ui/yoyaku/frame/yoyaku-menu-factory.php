<?php
namespace ui\yoyaku\frame;
require_once(dirname(__FILE__).'/../menu/yoyaku-select.php');

use ui\yoyaku\YoyakuContext;
use ui\yoyaku\menu\YoyakuSelect;

function main_yoyaku_factory() : Mainyoyaku
{
	$contxt = YoyakuContext::get_instance();
	return new YoyakuSelect();
}
?>
