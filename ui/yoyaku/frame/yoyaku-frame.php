<?php
namespace ui\yoyaku\frame;

abstract class YoyakuMenu
{
	public abstract function view();
	public abstract function get_title() : string;
	public function pre_render()
	{
	}

	protected function get_course_id_list() : array
	{
		return $_POST['course_id'];
	}

	protected function view_course_id_hidden()
	{
		foreach($this->get_course_id_list() as $course_id){
			echo "<input type='hidden' name='course_id[]' value='$course_id'>";
		}
	}

	protected function get_css_list() : array
	{
		return [];
	}
	
	protected function get_js_list() : array
	{
		return [];
	}

	public final function output_header(string $css_url, string $js_url, string $css_var, string $js_var)
	{
		foreach($this->get_css_list() as $css)
		{
		
			?>
			<link rel="stylesheet" href="<?php echo $css_url.'/'.$css; ?>?ver=<?php echo $css_var; ?>"  type="text/css" />
			<?php
		}
		
		foreach($this->get_js_list() as $js)
		{
			?>
			<script type="text/javascript" charset="utf-8" src="<?php echo $js_url.'/'.$js; ?>?ver=<?php echo $js_var; ?>" ></script>
			<?php
		}
	}
}

class YoyakuFrame
{
	private $_main_yoyaku;
	
	public function __construct(YoyakuMenu $m)
	{
		$this->_main_yoyaku = $m;
	}
	
	public function view()
	{
		$this->_main_yoyaku->pre_render();

		$css_dir =  plugins_url()."/saron/css/yoyaku/";
		$js_dir =  plugins_url()."/saron/js/";
		$css_ver = '0.04';
		$js_ver = '0.06';
		?>	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja"><head>
		<title>
		<?php echo $this->_main_yoyaku->get_title(); ?>
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
		<link rel="stylesheet" href="<?php echo $css_dir."common.css?ver=$css_ver"; ?>"  type="text/css"; />
		<link rel="stylesheet" href="<?php echo $css_dir."yoyaku-footer-form.css?ver=$css_ver"; ?>"  type="text/css" />
		<?php $this->_main_yoyaku->output_header($css_dir, $js_dir, $css_ver, $js_ver); ?>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="msapplication-config" content="none"/>
		</head>
		<body>
		<div class="yoyaku_wrap">
			<div class="inner_wrap">
			<div class="main">
			<?php
				$this->_main_yoyaku->view();
			?>
			</div>
			<div class="footer">
			<?php
				view_footer();
			?>	
			</div>
			</div>
		</div>
		<iframe style="height:0px;width:0px;visibility:hidden" src="about:blank">
			this frame prevents back forward cache
		</iframe>
		<body>
		<?php
		
		
	}
}


?>