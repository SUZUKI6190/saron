<?php
	namespace ui\frame;
	require_once("hedear-item.php");

	abstract class ManageFrame
	{
		protected $_item_list;

		public function __construct($hedear_item)
		{
			$this->_item_list = $header_item;
		}

		public void view()
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
		}
		
		abstract protected function view_main();
		
	}

?>