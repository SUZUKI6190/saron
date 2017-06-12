<?php
namespace ui\yoyaku\frame;
use ui\yoyaku\YoyakuContext;
use ui\yoyaku\YoyakuParam;

abstract class YoyakuMenu
{
	public abstract function view();
	public abstract function get_title() : string;
	
	private $_menu_id;
	private $_course_id_list;
	protected $_is_view_footer = true;

	private function setup_session( $yp)
	{
		$key = $yp->get_key();
		if(isset($_POST[$key])){
			$yp->set_value($_POST[$key]);
		}
	}

	public function is_view_footer() : bool
	{
		return $this->_is_view_footer;
	}

	public function init()
	{
		$yc = YoyakuContext::get_instance();
		$this->setup_session($yc->course_id_list);
		$this->setup_session($yc->staff_id);
		$this->setup_session($yc->yoyaku_date_time);
		$mc = $yc->mail_contents;
		$this->setup_session($mc->name_kanji);
		$this->setup_session($mc->name_kana);
		$this->setup_session($mc->email);
		$this->setup_session($mc->tell);
		$this->setup_session($mc->visit);
		$this->setup_session($mc->consultation);
		$this->init_inner();
	}

	protected abstract function init_inner();
	
	public function pre_render()
	{
	}

	protected function get_menu_id()
	{
		if(isset($_POST['menu_id'])){
			return $_POST['menu_id'];
		}else{
			return "";
		}
	}

	protected function set_menu_id(int $value)
	{
		$this->_menu_id = $value;
	}

	protected function set_course_id_list(array $v)
	{
		$this->_course_id_list = $v;
	}

	protected function get_course_id_list() : array
	{
		$yc = YoyakuContext::get_instance();
		return $yc->course_id_list->get_value();
	}

	protected function view_yoyaku_frame_hidden()
	{
		$m;
		if(empty($this->_menu_id)){
			$m = $this->get_menu_id();
		}else{
			$m = $this->_menu_id;
		}

		echo "<input type='hidden' name='menu_id' value='$m'>";
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
		$this->_main_yoyaku->init();
		$this->_main_yoyaku->pre_render();

		$css_dir =  plugins_url()."/saron/css/yoyaku/";
		$js_dir =  plugins_url()."/saron/js/";
		$css_ver = '0.06';
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
			if($this->_main_yoyaku->is_view_footer()){
				view_footer();
			}
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