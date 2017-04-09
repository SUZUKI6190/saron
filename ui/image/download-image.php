<?php
namespace ui\image;
require_once('image-factory.php');

class ImageDonwloader
{
	private $_id, $_sub_id;
	public $css_class = '';
	public function __construct(string $id, string $sub_id)
	{
		$this->_id = $id;
		$this->_sub_id = $sub_id;
	}

	private function create_url():string
	{
		return get_bloginfo('url')."/".get_query_var( 'pagename' ).'/image'."/$this->_id/$this->_sub_id";
	}
	
	public function view()
	{
		$css = '';
		if(!empty($this->css_class))
		{
			$css = "class = '$this->css_class'";
		}
		?>
		<img id='<?php echo $this->_id; ?>' src='<?php echo $this->create_url(); ?>' <?php echo $css; ?> />
		<?php
	}
	
	public static function create_page($id, $sub_id)
	{
		$img = create_image($id, $sub_id);
		//header('Content-Type: application/octet-stream');
		//header('Content-Disposition: attachment; filename=data.csv');
		header("Content-Type: ".$img->mime);
		echo $img->imgdat;
	}
}

?>