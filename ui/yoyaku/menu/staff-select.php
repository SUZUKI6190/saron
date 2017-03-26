<?php
namespace ui\yoyaku\menu;
use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\controll\MenuTable;
use ui\yoyaku\YoyakuContext;

class StaffSelect extends YoyakuMenu
{
	private $_selected_menu_table;
	private $_rest_menu_table;
	private $_menu_list = [];
	private $_selected_list = [];
	private $_form_id = 'rest_form';

	public function __construct()
	{
		$yc = YoyakuContext::get_instance();
	}
	
	public function get_title() : string
	{
		return "セラピスト選択";
	}
	
	public function view()
	{
		
		echo '作成中';
	}
}

?>