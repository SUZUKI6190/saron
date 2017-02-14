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
		if(empty($_POST[$this->_name]))
		{
			return "";
		}
			
		return date('Ymd', strtotime($_POST[$this->_name]));
	}

	public function is_empty()
	{
		return empty($_POST[$this->_name]);
	}
	
	private function convert_inputDateFormat($strDate)
	{
		return date('Y-m-d',strtotime($strDate));
	}
}

abstract class submit_base
{
	protected $_style;
	protected $_text;
	protected $_name;
	protected $_form_id;
	public function get_name() : string
	{
		return $this->_name;
	}
	public abstract function view();
	public function __construct($name, $text , $form_id, $style="")
	{
		$this->_name = $name;
		$this->_text = $text;
		$this->_form_id = $form_id;
		$this->_style = $style;
	}

	public function is_submit() : bool
	{
		return isset($_POST[$this->_name]);
	}
}

class SortButton extends submit_base
{
	const normal = "";
	const descending = "▲";
	const ascending = "▼";
	
	public function view()
	{
		$value_set = SortButton::normal;

		if($this->is_submit())
		{
			$value = $_POST[$this->_name];
			switch($value)
			{
				case SortButton::normal:
					$this->_text = $this->_text.SortButton::descending;
					$value_set = SortButton::descending;
					break;
				case SortButton::descending:
					$this->_text = $this->_text.SortButton::ascending;
					$value_set = SortButton::ascending;
					break;
				case SortButton::ascending:
					$this->_text = $this->_text.SortButton::descending;
					$value_set = SortButton::descending;
					break;
			}
		}else{
			$this->_text = $this->_text.SortButton::normal;
		}
		?>
		<a href="javascript:void(0)" onClick="FormSubmit('<?php echo $this->_form_id; ?>', '<?php echo $this->_name; ?>', '<?php echo $value_set; ?>');"><?php echo $this->_text; ?></a>
		<?php
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


function confirm_submit_button($text, $msg, $name = "", $add_style="")
{
	?>
	<input type='submit' value="<?php echo $text; ?>" name="<?php echo $name; ?>" class="manage_button <?php echo $add_style; ?>"  onClick="return check('<?php echo $msg; ?>');" />
	<?php
}


function numeric_input($name, $value, $class = "")
{
	?>
		<input name='<?php echo $name; ?>' type="number" value='<?php echo $value; ?>' pattern="^[0-9]+$" title="数字" style = "<?php echo $class; ?>" />
	<?php
}

?>