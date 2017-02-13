<?php
namespace ui;
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
	private static $heaer_name = "heqader_submit";

	public function is_sort_change():bool
	{
		return !empty($_POST[TableGenerator::$heaer_name]);
	}

	public function sort_table()
	{
		$value = $_POST[TableGenerator::$heaer_name];
		$selected_header = array_values(array_filter($this->HeaderDataSource, function($data) use(&$value){
			return $data->header_name == $value;
		}));

		if(count($selected_header) > 0)
		{	
			usort($this->DataSource , function($d1,$d2) use(&$selected_header) {
				return $selected_header[0]->sort($d1, $d2);
			});
		}
	}
	
	public function GenerateTable($formid)
	{
?>
		<table>
		<thead><tr>
		<?php
		foreach($this->HeaderDataSource as $data)
		{
			echo "<th>";
			echo $data->header_text;
			$name = $data->header_name;
			if($name != ""){
				?>
				<a href="javascript:void(0)" onClick="FormSubmit('<?php echo $formid; ?>', '<?php echo TableGenerator::$heaer_name; ?>', '<?php echo $name; ?>');">▼</a>
				<?php
			}
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