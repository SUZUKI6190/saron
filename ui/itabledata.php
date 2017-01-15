<?php
namespace ui;
interface ITableData
{
	function RowGenerator();
}

interface IHeaderData
{
	function HeaderGenerator();
}

class TableGenerator
{
	public $DataSource = [];
	public $HeaderDataSource = [];
	
	public function GenerateTable()
	{
		echo "<table>";
		echo "<thead><tr>";
		foreach($this->HeaderDataSource as $data)
		{
			echo "<th>";
			echo $data;
			?>
			<span>▼</span>
			<?php
			echo "</th>";
		}
		echo "</tr></thead>";
		echo "<tr>";
		foreach($this->DataSource as $data)
		{
			foreach($data->RowGenerator() as $d)
			{
				echo "<td>";
				echo $d;
				echo "</td>";
			}
			echo "</tr>";
		}
		
		echo "</table>";
	}
}
?>