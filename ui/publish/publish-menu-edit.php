<?php
namespace ui\publish;
require_once('publish-menu.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
use \business\entity\Menu;
use \business\entity\MenuCourse;
use \ui\util\SubmitButton;
use \ui\util\InputBase;

class ViewMenuDetailEdit extends ViewMenuDetail
{
	private $_add_course_button;
	public function __construct(Menu $menu, $form_id)
	{
		parent::__construct($menu, $form_id);
		$this->_add_course_button = new SubmitButton("add_course" ,'新しいコースを追加する', $this->_form_id);
	
	}
	public function save_inner(Menu $menu)
	{
		
	}
	
	public function view()
	{
		if($this->_add_course_button->is_submit())
		{
			return;
		}

		parent::view();
		?>
		<div class="input_form">
		<div class="line">
			<div>コース</div>
			<?php
			$this->_add_course_button->view();
			foreach($this->_menu->course_list as $couse)
			{?>
			
			<?php
			}
			?>
		</div>
		
		</div>
<?php
	}
}

?>