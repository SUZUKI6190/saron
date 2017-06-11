<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;

class Confirm extends YoyakuMenu
{

	public function __construct()
	{

	}

	protected function init_inner()
	{
	}
	protected function get_css_list() : array
	{
		return [
		"confirm.css"
		];
	}

	public function get_title() : string
	{
		return "確認画面";
	}

	public function view()
	{
		?>

	<?php
	}

}

?>