<?php
namespace ui\sales;
require_once('sales-mail/sales-mail-editor-base.php');
require_once('sales-mail/sales-mail-editor-new.php');
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
    const EditFlgName = "EditFlg";
    const EditValueName = "EditValue";
    private $_mail_list;

    private function is_edit():bool
    {
        return isset($_POST[self::EditFlgName]);
    }
    
    private function get_edit_id()
    {
        if(isset($_POST[self::EditValueName])){
            return $_POST[self::EditValueName];
        }else{
            return "";
        }
    }

	public function init()
	{
	}

	public function view()
	{
        $d = "?d=".(new \DateTime())->format("Ymdhis");
    ?>
    <form method='post' action='<?php echo $d; ?>'>
        <div class='setting_width centering'>
        <?php
        if($this->is_edit()){
            $view;
            if($this->get_edit_id()){
                
            }else{
                $view = new SalesMailEditorNew();   
            }
            $view->view();
        }else{
            $this->view_list();
        }
        ?>
        </div>
    </form>
        <?php
	}

    private function view_list()
    {
        $this->_mail_list = SalesMailFacade::get_all();
        $edit_key = self::EditFlgName;
    ?>
    <div class='new_btn_area'>
        <button class='manage_button' type='submit' name='<?php echo self::EditFlgName; ?>' value=''>新しく追加する</button>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>
                        メールアドレス
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <?php
            foreach($this->_mail_list as $m)
            {
            ?>
			<tr>
				<td class="email">
					<?php
					echo $m->email;
					?>
				</td>
				<td class='cmd_td'>
					<?php echo "<button class='manage_button' type='submit' name='$edit_key' value='$m->id'>編集</button>"; ?>
				</td>
			</tr>
			<?php
            }
            ?>
        </table>
    </div>
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