<?php
	namespace ui\frame;
	require_once("header-item.php");

	abstract class ManageFrame
	{

		public function view()
		{
			$mc = ManageFrameContext::get_instance();
			?>
			<div class = "main_header_wrap">
			<?php
			foreach($mc->main_category_list as $main_category)
			{
				$hb = new MainHeaderItem();
				$hb->name = $main_category->text;
				$hb->url = $mc->get_url()."/".$main_category->name;
				$hb->view();
			}
			
			?>
			</div>
			<div class = "sub_header_wrap">
				
			</div>
			<?php
			
			$this->view_main();
		}
		
		abstract protected function view_main();
		
	}

?>