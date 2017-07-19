<?php
	namespace ui\frame;
	require_once("header-item.php");
	require_once("result.php");
	
	class HeaderFile
	{
		public $name, $ver;
		public function __construct(string $name, float $ver)
		{
			$this->ver = $ver;
			$this->name = $name;
		}
	}
	
	abstract class ManageFrameImplementor
	{
		public abstract function get_sub_category_list();
		public abstract function view_main();
		public function create_result() : Result
		{
			return new Result();
		}

		protected function get_css_list()
		{
			return [];
		}
		
		protected function get_js_list()
		{
			return [];
		}
		
		public function output_header(string $css_url, string $js_url, string $css_var)
		{
			
			foreach($this->get_css_list() as $css)
			{
				
				?>
				<link rel="stylesheet" href="<?php echo $css_url.'/'.$css->name; ?>?ver=<?php echo $css_var; ?>"  type="text/css" />
				<?php
			}
			
			foreach($this->get_js_list() as $js)
			{
				?>
				<script type="text/javascript" charset="utf-8" src="<?php echo $js_url.'/'.$js->name; ?>?ver=<?php echo $js->ver; ?>" ></script>
				<?php
			}
		}
	}
	
	class ManageFrame
	{
		private $_frame_implementor;
		private $_main_catgory_list;
		private $_selected_sub;
		private $_main_category;
		private $_sub_list;

		public function __construct($main_list, $frame_implementor)
		{
			$mc = ManageFrameContext::get_instance();

			$this->_frame_implementor = $frame_implementor;
			$this->_main_catgory_list = $main_list;
			$this->_selected_main_category = $mc->get_selected_main_category();
			$this->_sub_list = $this->_frame_implementor->get_sub_category_list();
			$this->_selected_sub = $this->_sub_list[$mc->selected_sub_category_name];
		}

		public function pre_view()
		{
			$this->_selected_sub->pre_view();
		}

		public function view()
		{			
			$css_url = plugins_url("../../css" , __FILE__);
			$js_url = plugins_url("../../js" , __FILE__);
			$cssvar = '0.3';
		?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
			<head>
			<title>予約システム管理画面</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Pragma" content="no-cache" />
			<meta http-equiv="Cache-Control" content="no-cache" />
			<meta http-equiv="Cache-Control" content="no-store" />
			<meta http-equiv="Pragma" content="no-cache">
			<meta http-equiv="Cache-Control" content="no-cache">
			<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
			<script type="text/javascript" charset="utf-8" src="<?php echo $js_url."/ui-util.js?ver=0.05"; ?>" ></script>
			<link rel="stylesheet" href="<?php echo $css_url."/manage_common.css?ver=$cssvar"; ?>"  type="text/css" />
			<link rel="stylesheet" href="<?php echo $css_url."/manage_header.css?ver=$cssvar"; ?>"  type="text/css" />
			<link rel="stylesheet" href="<?php echo $css_url."/customer_search.css?ver=$cssvar"; ?>"  type="text/css" />
			<link rel="stylesheet" href="<?php echo $css_url."/customer_view.css?ver=$cssvar"; ?>"  type="text/css" />
			<?php $this->_frame_implementor->output_header($css_url, $js_url, $cssvar); ?>
			<meta name="format-detection" content="telephone=no"/>
			<meta name="msapplication-config" content="none"/>
			</head>
			<body>
			<div class='logout_area'>
				<form name='form1' action='' method='post'>
					<input type='hidden' name='<?php echo ManageFrameContext::LogoutBtnName; ?>'>
					<a href="#" onClick="document.form1.submit();">ログアウト</a>
				</form>
			</div>
			<div class="main_wrap">
			<?php
				
			$this->view_sub();

			?>
			</div>
			<iframe style="height:0px;width:0px;visibility:hidden" src="about:blank">
				this frame prevents back forward cache
			</iframe>
			<body>
			<?php
		}

		public function view_sub()
		{
			$mc = ManageFrameContext::get_instance();
			$d = "?d=".(new \DateTime())->format("Ymdhis");

			?>
			<div class = "main_header_wrap">
			<div class="centering">
				<?php
				foreach($this->_main_catgory_list as $key => $main_category)
				{
					$hb = new MainHeaderItem();
					$hb->name = $main_category->text;
					$hb->url = $mc->get_url()."/".$main_category->name."/".$main_category->default_name.$d;
					if($main_category->name ==  $this->_selected_main_category->name)
					{
						\ui\util\main_header_button($hb->name, $hb->url, 'selected');
					}else{
						\ui\util\main_header_button($hb->name, $hb->url);
					}
				}
				?>
				</div>
			</div>
			
			<div class = "sub_header_area">
				<div class="centering">
				<?php
				
				foreach($this->_sub_list as $key => $sub_cate)
				{
					$url = $mc->get_url()."/".$this->_selected_main_category->name."/".$sub_cate->get_name().$d;
					\ui\util\link_button($sub_cate->get_title_name(),  $url, "sub_header_button");
				}
				?>
				</div>
			</div>

			<div class ="main_content centering">
			<?php
			$this->_selected_sub->init();
			$result = $this->_selected_sub->get_result();
			if($result->is_regist_finished()){
				$this->_selected_sub->regist();
				view_result($result);
			}else{
				$this->_selected_sub->view();
				$this->_frame_implementor->view_main();
			}

			?>
			</div>
			<?php
		}
	}

?>