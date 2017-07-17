<?php
namespace ui\sales;
require_once('sales-mail/sales-mail-viewer.php');
require_once('sales-mail/sales-mail-list.php');
require_once('sales-mail/sales-mail-editor-base.php');
require_once('sales-mail/sales-mail-editor-new.php');
require_once('sales-mail/sales-mail-editor-edit.php');
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

    private $_mail_list;
    private $_flg_value;

    private function is_edit():bool
    {
        return isset($_POST[SalesMailContext::EditBtnName]);
    }
    
	public function init()
	{
        $this->save();
        $this->_viewer = $this->create_viewer();
        $this->_viewer->init();
	}

    private function save()
    {
        if(isset($_POST[SalesMailContext::SaveKey]))
        {                       
            $viewer;
            $v = $_POST[SalesMailContext::SaveKey];
            if($v == SalesMailContext::EditKeyValue){
                $viewer =new SalesMailEditorEdit();
            }else{
                $viewer = new SalesMailEditorNew();  
            }
            $viewer->init();
            $viewer->save();
        }
    }

    private function create_viewer() : ISalesMailViewer
    {
        $sc = SalesContext::get_instance();
        if($this->is_edit()){
            $viewer;
            $id = $sc->sales_mail_context->get_edit_sales_id();
            if($id == ''){
                $this->_flg_value = SalesMailContext::NewKeyValue;
                $viewer = new SalesMailEditorNew();
            }else{
                $this->_flg_value = SalesMailContext::EditKeyValue;
                $viewer = new SalesMailEditorEdit();
            }
            return $viewer;
        }else{
            $list =  new SalesMailList();
            $list->edit_btn_name = SalesMailContext::EditBtnName;
            $list->new_btn_name = SalesMailContext::EditBtnName;
            return $list;
        }
    }

	public function view()
	{
        $d = "?d=".(new \DateTime())->format("Ymdhis");
    ?>
    <form method='post' action='<?php echo $d; ?>'>
        <div class='setting_width centering'>
        <?php
        $this->_viewer->view();
        ?>
        </div>
        <input type="hidden" name='<?php echo SalesMailContext::SaveKey; ?>' value="<?php echo $this->_flg_value; ?>" >
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