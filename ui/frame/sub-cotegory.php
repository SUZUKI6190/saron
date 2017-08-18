<?php
namespace ui\frame;
require_once("result.php");

use ui\frame\Result;

abstract class SubCategory
{
	abstract public function view();
	abstract public function get_name();
	abstract public function init();
	abstract public function get_title_name();
	public function get_result() : Result
	{
		return new Result();
	}
	public function regist()
	{
	}
	public function pre_view()
	{

	}
}


?>