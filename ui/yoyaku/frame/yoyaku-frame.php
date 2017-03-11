<?php
namespace ui\yoyaku\frame;

abstract class YoyakuMenu
{
	public abstract function view();
	protected function get_css_name()
	{
		return [];
	}
	
	protected function get_js_name()
	{
		return [];
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
		$css_dir =  plugins_url()."/saron/css/yoyaku/";
		$js_dir =  plugins_url()."/saron/js/";
		?>	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Expires" content="0" /><title></title>
		<link rel="stylesheet" href="<?php echo $css_dir."common.css?ver=0.01"; ?>"  type="text/css"; />
		<link rel="stylesheet" href="<?php echo $css_dir."yoyaku-footer-form.css?ver=0.01"; ?>"  type="text/css" />
		<link rel="stylesheet" href="<?php echo $css_dir."menu-table.css"; ?>?ver=0.01"  type="text/css" />
		<script type="text/javascript" charset="utf-8" src="<?php echo $js_dir ?>/menu-select.js?ver=0.03" ></script>
		<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
		<meta name="format-detection" content="telephone=no"/>
		<meta name="msapplication-config" content="none"/>
		</head>
		<body>
		<div class="main_wrap">
		<?php
			$this->_main_yoyaku->view();
		?>
		</div>
		<?php
			view_footer();
		?>	
		<body>
		<?php
		
		
	}
}

function init_yoyaku()
{


	function regist_css()
	{
		wp_register_style(
			'yoyaku/common.css', 
			plugins_url("/css/yoyaku/common.css", __FILE__),
			array(),
			"1.0"
			 
		);
		
		wp_enqueue_style('yoyaku/common.css');

		wp_register_style(
			'customer_search.css', 
			plugins_url("/css/customer_search.css", __FILE__),
			array(),
			"0.006"
			 
		);
		
		wp_enqueue_style('customer_search.css');
		
		wp_enqueue_style('manage_common.css');

		wp_register_style(
			'manage_common.css', 
			plugins_url("/css/manage_common.css", __FILE__),
			array(),
			"0.002"
		);
		
		wp_enqueue_style('manage_common.css');
	}

	add_action('wp_enqueue_scripts', 'regist_css');

}

?>