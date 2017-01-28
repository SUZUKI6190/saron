<?php
namespace ui\frame;
require_once("manage-frame-context.php");

abstract class HeaderItem
{
	public $sub_header_list;
	public $name;
	public $url;

	abstract public function is_selected();
	
	public function view()
	{
		
		?>
		<a href = '<?php echo $this->url; ?>' class='header_button' >
			<div class="main_header_button">
				<?php echo $this->name; ?> 
			</div>
		</a>
		<?php
	}
}

class MainHeaderItem extends HeaderItem
{
	public function is_selected()
	{
		$mc = ManageFrameContext::get_instance();
		return $mc->current_main_category->name == $this->get_name();
	}
	
}

class SubHeaderItem extends HeaderItem
{
	public function is_selected()
	{
		$mc = ManageFrameContext::get_instance();
		return $mc->current_sub_category->get_name() == $this->get_name();
	}
}

?>