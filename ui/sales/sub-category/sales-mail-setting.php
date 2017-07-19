<?php
namespace ui\sales;
require_once('sales-mail-viewer-factory.php');
use ui\frame\ManageFrameContext;
use \business\facade;
use \ui\util\SubmitButton;
use \ui\util\InputBase;
use \ui\util\ConfirmSubmitButton;
use \ui\frame\Result;
use ui\sales\SalesContext;
use \business\facade\SalesMailFacade;

class SalesMailSettingSub extends \ui\frame\SubCategory
{
    private $_viewer;

	public function init()
	{
        $this->save();
        $this->_viewer = SalesMailViewerFactory::create_viewer();
        $this->_viewer->init();
	}

    private function save()
    {
        $sc = SalesContext::get_instance();
        $viewer = SalesMailViewerFactory::create_pre_viewer(); 
        $viewer->save();
    }

	public function view()
	{
        $d = "?d=".(new \DateTime())->format("Ymdhis");        
        $sc = SalesContext::get_instance();
        $page_Id = $sc->sales_mail_context->get_page_Id();
    ?>
    <form method='post' action='<?php echo $d; ?>'>
        <div class='setting_width centering'>
            <div class='new_btn_area'>
                <button class='manage_button' type='submit' name='<?php echo SalesMailContext::ContentID; ?>' >メール設定</button>
                <button class='manage_button' type='submit' name='<?php echo SalesMailContext::NewID; ?>'>新しく追加</button>
            </div>
            
            <?php
            $this->_viewer->view();
            ?>
        </div>
        <input type='hidden' name='<?php echo SalesMailContext::PageIdKey; ?>' value='<?php echo $page_Id; ?>'>
    </form>
        <?php
	}

	public function get_name()
	{
		return "salesmail";
	}
	
	public function get_title_name()
	{
		return "売上メール設定";
	}
	
}
?>