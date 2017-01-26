<?php
namespace ui\frame;

abstract class HeaderItem
{
	public $sub_header_list;
	abstract function get_name();
	abstract function get_url();

	public function is_selected()
	{
	}
	
	public function view()
	{
		?>
		<a href = '<?php echo $this->get_url(); ?>' class='header_button' >
			<span>
				<?php echo $this->get_name(); ?> 
			</span>
		</a>
		<?php
	}
}

?>