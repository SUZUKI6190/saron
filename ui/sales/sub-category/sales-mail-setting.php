<?php
namespace ui\sales;
require_once('sales-mail/sales-mail-viewer-facory.php');
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
    
    const ListID = 0;
    const NewID = 0;
    const EditID = 0;
    const ContentID = 0;
	public function init()
	{
        $this->save();
        $this->_viewer = $this->create_viewer();
        $this->_viewer->init();
	}

    private function create_viewer($id): ISalesMailViewer
    {
        $v;
        switch($id){
            case self::NewID:
                $v = new SalesMailEditorNew();  
                break;
            case self::EditID:
                $v = new SalesMailEditorEdit();
                break; 
            case ContentID:
                $v = new SalesMailContent();
                break;
            case default:
                $v = new SalesMailList()
                $v->edit_btn_name = SalesMailContext::EditBtnName;
                $v->new_btn_name = SalesMailContext::EditBtnName;
                $v->delete_btn_name = SalesMailContext::DeleteBtnName;
                $v->mail_edit_btn_name =SalesMailContext::MailEditBtnName;
                break;
        }
        return $v;
    }

    private function save()
    {
        $viewer;
        $sc = SalesContext::get_instancviewer = new SalesMailList();e();
        
        if($sc->sales_mail_context->is_edit_confirm_click())
        {                       
            $v = $sc->sales_mail_context->get_edit_sales_id();
            if($v != ''){
                $viewer = new SalesMailEditorEdit();
            }else{
                $viewer = new SalesMailEditorNew();  
            }
            $viewer->save();
        }
    
        if(isset($_POST[SalesMailContext::DeleteBtnName]))
        { 
            $viewer = new SalesMailList();
            $viewer->save();
        }
    
    }

    private function create_viewer() : ISalesMailViewer
    {
        $sc = SalesContext::get_instance();
        if($sc->sales_mail_context->is_edit_click()){
            return $this->get_edit_viwer();
        }else{
            $v;
            if($sc->sales_mail_context->is_mail_edit_click()){
                $v = new SalesMailContent();
            }else{
                $v =  new SalesMailList();
                $v->edit_btn_name = SalesMailContext::EditBtnName;
                $v->new_btn_name = SalesMailContext::EditBtnName;
                $v->delete_btn_name = SalesMailContext::DeleteBtnName;
                $v->mail_edit_btn_name =SalesMailContext::MailEditBtnName;
            }
            return $v;
        }
    }

    private function get_edit_viwer(): ISalesMailViewer
    {
        $sc = SalesContext::get_instance();
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
        <input type='hidden' name='<?php echo self::PageFrg; ?>'>
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