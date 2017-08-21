<?php
namespace ui\image;
require_once(dirname(__FILE__).'/../../business/entity/staff.php');
require_once(dirname(__FILE__).'/../../business/facade/staff.php');
use business\entity\Image;

function create_image($id, $sub_id):Image
{
	if($id == 'staff'){
		return \business\facade\get_staff_image_by_id($sub_id);
	}else{
		return new Image();
	}
}

?>