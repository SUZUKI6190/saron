<?php
	namespace ui\frame;
	require_once("header-item.php");
	require_once("result.php");
	
	abstract class ManageFrameImplementor
	{
		public abstract function get_sub_category_list();
		public abstract function view_main();
		public function create_result() : Result
		{
			return new Result();
		}
		public function get_selected_sub_category()
		{
			$mc = ManageFrameContext::get_instance();
			$sub_list = $this->get_sub_category_list();
			
			return $sub_list[$mc->selected_sub_category_name];
		}
	}
	
	class ManageFrame
	{
		private $_frame_implementor;
		private $_main_catgory_list;
		public function __construct($main_list, $frame_implementor)
		{
			$this->_frame_implementor = $frame_implementor;
			$this->_main_catgory_list = $main_list;
		}

		public function view()
		{
			$mc = ManageFrameContext::get_instance();

			$main_cate_list = $this->_main_catgory_list;

			$main_cate = $mc->get_selected_main_category();
			?>
			<div class = "main_header_wrap">
			<div class="centering">
				<?php
				foreach($main_cate_list as $key => $main_category)
				{
					$hb = new MainHeaderItem();
					$hb->name = $main_category->text;
					$hb->url = $mc->get_url()."/".$main_category->name."/".$main_category->default_name;
					if($main_category->name == $main_cate->name)
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
				$sub_list = $this->_frame_implementor->get_sub_category_list();
				
				foreach($sub_list as $key => $sub_cate)
				{
					$url = $mc->get_url()."/".$main_cate->name."/".$sub_cate->get_name();
					\ui\util\link_button($sub_cate->get_title_name(),  $url, "sub_header_button");
				}
				?>
				</div>
			</div>

			<div class ="main_content centering">
			<?php

			$selected_sub = $this->_frame_implementor->get_selected_sub_category();
			$result = $selected_sub->get_result();
			if($result->is_regist_finished()){
				$selected_sub->regist();
				view_result($result);
			}else{
				$selected_sub->view();
				$this->_frame_implementor->view_main();
			}

			?>
			</div>
			<?php
		}
	}

?>