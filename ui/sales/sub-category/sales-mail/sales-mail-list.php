<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailList implements ISalesMailViewer
{
    private $_mail_list;

    public function init()
    {
    }

    public function save()
    {
        if(isset($_POST[SalesMailContext::DeleteBtnName])){
            $sc = SalesContext::get_instance();
            $id = $sc->sales_mail_context->get_delete_sales_id();
            SalesMailFacade::delete_by_id($id);
        }
    }

    public function get_page_no() : int
    {
        
    }

    public function view()
    {
        $this->_mail_list = SalesMailFacade::get_all();
        $edit_id = SalesMailContext::EditID;
        $delete_id = SalesMailContext::DeleteBtnName;
    ?>
    <div class='list_area'>
        <table class='list_table'>
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
					<?php echo "<button class='manage_button' type='submit' name='$edit_id' value='$m->id'>編集</button>"; ?>
				</td>
				<td class='cmd_td'>
                    <?php
                    \ui\util\confirm_submit_button('削除', '本当に削除しますか？', $delete_id, $m->id);
                    ?>
				</td>
			</tr>
			<?php
            }
            ?>
        </table>
    </div>
    <?php
    }
}
?>