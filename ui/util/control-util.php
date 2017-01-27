<?php
namespace ui\util;

class view_date_input
{

	private $_name;
	
	public function __construct($name)
	{
		$this->_name = $name;
	}
	
	public function view($value)
	{
		$converted = $this->convert_inputDateFormat($value);
		?>
		<input name='<?php echo $this->_name; ?>' type="date" value='<?php echo $converted; ?>' />
		<?php
	}
	
	public function get_selected_value()
	{
		return date('Ymd', strtotime($_POST[$this->_name]));
	}

	private function GetDatePostData($key)
	{
		return date('Ymd',strtotime($_POST[$key]));
	}
	
	private function convert_inputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
	}
}

?>