<?php
namespace ui\yoyaku\menu;

use ui\yoyaku\frame\YoyakuMenu;
use ui\yoyaku\YoyakuContext;
USE ui\util\InputBase;
use ui\util\SubmitButton;
require_once(dirname(__FILE__).'/../controll/course-table.php');
use ui\yoyaku\controll\CourseTable;


class MailInput extends YoyakuMenu
{
    public function view()
    {

    }

	public function get_title() : string
    {
        return "情報入力";
    }
}

?>