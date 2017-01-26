<?php
namespace ui;

class MainCategory
{
	private $_sub_category_list;
	public $category_name;
}

abstract class SubCategory
{
	abstract public view();
}


function CreateCategory($id)
{
	switch($id)
	{
		case "costomer";
			break;
	}
}

?>