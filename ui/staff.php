<?php

namespace ui;
require_once(dirname(__FILE__)."/../business/facade/staff.php");
require_once(dirname(__FILE__)."/../business/entity/staff.php");
class ViewStaff
{
	private $_name;
	private $_class_name;
	
	public function __construct($name, $class_name = "")
	{
		$this->_name = $name;
		$this->_class_name = $class_name;
	}
	
	public function view_staff_select($selected_id = "")
	{
		$staff_list = \business\facade\get_staff_all();
		
		echo "<select name='$this->_name' class = '$this->_class_name'>";
			
			foreach($staff_list as $staff_data)
			{
				$name = $staff_data->name_last.$staff_data->name_first;
				$id = $staff_data->id;
				if($selected_id == $id){
					echo "<option value='$id' selected>$name</option>";
				}else{
					echo "<option value='$id'>$name</option>";
				}
			}
	
		echo "</select>";
	
	}

	public function get_value()
	{
		if(empty($_POST[$this->_name])){
			return "";
		}else{
			return $_POST[$this->_name];
		}
	}
}

?>