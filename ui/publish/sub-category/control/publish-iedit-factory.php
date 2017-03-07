<?php
namespace ui\publish;
require_once("publish-menu-new.php");
require_once("publish-menu-edit.php");
use ui\IEdit;
use ui\publish\PublishContext;

function create_publish_edit($form_id) : IEdit
{
	$iedit;
	$pc = PublishContext::get_instance();
	
	if(empty($pc->menu_id)){
		$iedit = new ViewMenuDetailNew($form_id);
	}else{
		if(empty($pc->is_course_edit)){
			$iedit = new ViewMenuDetailEdit($form_id);
		}else{
			if(empty($pc->course_id)){
				$iedit = new MenuCourseNew($pc->menu_id, $form_id);
			}else{
				$iedit = new MenuCourseEdit($pc->menu_id, $form_id, $pc->course_id);
			}
		}
	}

	return $iedit;
}

?>