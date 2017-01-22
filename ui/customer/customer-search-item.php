<?php
namespace ui\customer;

abstract class SearchItem
{
	protected abstract function exist_criteria();
	protected abstract function get_criteria_query();
	protected abstract function view();
	protected function get_post($key)
	{
		return $_POST[$key];
	}
	
	protected function is_empty_post($key)
	{
		return empty($_POST[$key]);
	}
}

class SearchitemRepeater
{
	private _item_list;
	public function __construct($item_list)
	{
		$this->_item_list = $item_list;
	}
	
	public function create_where_query()
	{
		if(count($this-_item_list) == 0)
		{
			return '';
		}

		$exits_list = array_filter($this-_item_list, function($item){
			return $item->exist_criteria();
		})
		
		if(count($exits_list) == 0)
		{
			return '';
		}

		&add = 'where ';
		$strWhere;

		foreach($exits_list as $item)
		{
			$strWhere = &add.$strWhere.$item->get_criteria_query();
			&add = 'and ';
		}
		
		return $strWhere;
	}
	
	public function repeat(){
	?>
		<div class='area'>
		<?php

		foreach($this->_item_list as $item)
		{
			?>
			<div class='search_item_line'>
			<?php
			$item->view();
			?>
			</div>
			<?php
		}

		?>
		</div>
	}
}

?>