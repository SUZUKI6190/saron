<?php
	namespace ui\frame;
	require_once("header-item.php");
	
	abstract class ManageFrameImplementor
	{
		public abstract function get_sub_category_list();
		public abstract function view_main();
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

			?>
			<div class = "main_header_wrap">
				<?php
				foreach($main_cate_list as $key => $main_category)
				{
					$sub_list = $this->_frame_implementor->get_sub_category_list();
					$sub_name = "";
					if(count($sub_list) > 0)
					{
						$sub_name = reset($sub_list)->get_name();
					}

					$hb = new MainHeaderItem();
					$hb->name = $main_category->text;
					$hb->url = $mc->get_url()."/".$main_category->name."/".$sub_name;
					$hb->view();
				}
				
				?>
			</div>
			<?php
			$main_cate = $mc->get_selected_main_category();
			?>
			<div class = "sub_header_area">
				<?php
				$sub_list = $this->_frame_implementor->get_sub_category_list();
				
				foreach($sub_list as $key => $sub_cate)
				{
					$url = $mc->get_url()."/".$main_cate->name."/".$sub_cate->get_name();
					?>
					<a href = '<?php echo $url; ?>'>
						<div class="sub_header_button">
							<?php
							echo $sub_cate->get_title_name();
							?>
						</div>
					</a>
					<?php
				}
				?>
			</div>
			<?php

			$selected_sub = $this->_frame_implementor->get_selected_sub_category();
			$selected_sub->view();
			$this->_frame_implementor->view_main();
		}
	}

?>