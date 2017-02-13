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
	public function __construct($text, $name)
	{
		$this->header_text = $text;
		$this->header_name = $name;
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