<?php
namespace ui;
use ui\util\SortButton;
interface ITableData
{
	function RowGenerator();
}

class HeaderData
{
	public $header_text = "";
	public $header_name = "";
	protected $compare_callbacks;

	public function __construct($text, $name, callable $callback)
	{
		$this->header_text = $text;
		$this->header_name = $name;
		$this->compare_callbacks = $callback;
	}
	
	public function sort($data1, $data2)
	{
		return call_user_func_array($this->compare_callbacks , [$data1, $data2]);
	}
}

class TableGenerator
{
	public $DataSource = [];
	public $HeaderDataSource = [];
	private $_header_button_list = [];
	private static $heaer_name = "heqader_submit";
	public function __construct($HeaderDataSource)
	{
		$this->HeaderDataSource = $HeaderDataSource;
		$this->_header_button_list = array_map( function($data) use(&$formid){
			return new \ui\util\SortButton($data->header_name, $data->header_text, $formid);
		} , $this->HeaderDataSource);
	}

	public function is_sort_change():bool
	{
		foreach($this->_header_button_list as $header_button)
		{
			if($header_button->is_submit())
			{
				return true;
			}
		}
		return false;
	}

	public function sort_table()
	{
		$selected_button_list = array_values(array_filter($this->_header_button_list, function($data){
			return $data->is_submit();
		}));
		
		if(count($selected_button_list) == 0)
		{
			return;
		}
		$selected_button = $selected_button_list[0];
		$selected_header = array_values(array_filter($this->HeaderDataSource, function($data) use(&$selected_button){
			return $data->header_name == $selected_button->get_name();
		}));

		if(count($selected_header) > 0)
		{	
			$convert_param = 1;
			if($selected_button->get_state() == SortButton::ascending)
			{
				$convert_param = -1;
			}
			usort($this->DataSource , function($d1,$d2) use(&$selected_header, &$convert_param) {
				return $convert_param * $selected_header[0]->sort($d1, $d2);
			});
		}
	}
	
	public function GenerateTable($formid)
	{
?>
		<table>
		<thead><tr>
		<?php
		$sort_button_list = array_map( function($data) use(&$formid){
			return new \ui\util\SortButton($data->header_name, $data->header_text, $formid);
		} , $this->HeaderDataSource);
		foreach($sort_button_list as $data)
		{
			echo "<th>";
			$data->view();
			echo "</th>";
		}
		?>
		</tr></thead>
		<tr>
		<?php
		foreach($this->DataSource as $data)
		{
			foreach($data->RowGenerator() as $d)
			{
				echo "<td>$d</td>";
			}
			echo "</tr>";
		}
		?>
		</table>
		
		<?php
	}
}
?>