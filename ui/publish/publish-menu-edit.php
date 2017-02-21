<?php
namespace ui\publish;
require_once('publish-menu.php');
require_once('publish-course.php');
require_once(dirname(__FILE__).'/../../business/facade/publish-menu.php');
use \business\entity\Menu;
use \business\entity\MenuCourse;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\publish\MenuCourseNew;
use \ui\publish\MenuCourseForm;
class ViewMenuDetailEdit extends ViewMenuDetail
{

	public function __construct(Menu $menu, $form_id)
	{
		parent::__construct($menu, $form_id);

	}

	public function save_inner(Menu $menu)
	{
		
	}
	
	public function is_course_view() : bool
	{
		return $this->_add_course_button->is_submit();
	}
	
	public function view()
	{
		parent::view();
		?>

<?php
	}
}

?>