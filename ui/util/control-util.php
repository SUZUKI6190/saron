<?php
namespace ui\util;

class view_date_input
{

	private $_name;
	
	public function __construct($name)
	{
		$this->_name = $name;
	}
	
	public function view($value = "")
	{
		if(is_null($value == "") or empty($value)){
			$converted = "";
		}else{
			$converted = $this->convert_inputDateFormat($value);
		}
		?>
		<input name='<?php echo $this->_name; ?>' type="date" value='<?php echo $converted; ?>' />
		<?php
	}
	
	public function get_selected_value()
	{
		return date('Ymd', strtotime($_POST[$this->_name]));
	}

	public function is_empty()
	{
		return empty($_POST[$this->_name]);
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

function main_header_button($text , $url)
{
	?><div class="main_header_button">
	<a href = '<?php echo $url; ?>'>
		<?php echo $text; ?>
	</a>
	</div><?php
}

function link_button($text , $url, $add_style = "")
{
	?>
		<a href = '<?php echo $url; ?>' class="manage_button <?php echo $add_style; ?>">
			<?php echo $text; ?>
		</a>
	<?php
}

function submit_button($text, $name = "", $add_style="")
{
	?>
	<input type='submit' value="<?php echo $text; ?>" name="<?php echo $name; ?>" class="manage_button <?php echo $add_style; ?>"  />
	<?php
}

function numeric_input($name, $value, $class = "")
{
	?>
		<input name='<?php echo $name; ?>' type="number" value='<?php echo $value; ?>' pattern="^[0-9]+$" title="数字"style = "<?php echo $class; ?>" />
	<?php
}

?>