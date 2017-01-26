<?php
	namespace ui\frame;
	require_once("header-item.php");

	abstract class ManageFrame
	{
		protected $_item_list;

		public function __construct($header_item)
		{			
			$this->_item_list = $header_item;
		}

		public function view()
		{
			?>
			<div class = "main_header">
			<?php
			foreach($this->_item_list as $header_item)
			{
				$header_item->view();
			}
			
			?>
			</div>
			<div class = "sub_header">
				
			</div>
			<?php
			
			$this->view_main();
		}
		
		abstract protected function view_main();
		
	}

?>