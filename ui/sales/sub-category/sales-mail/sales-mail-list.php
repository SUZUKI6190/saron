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
        $sc = SalesContext::get_instance();
        $id = $sc->sales_mail_context->get_delete_sales_id();
        SalesMailFacade::delete_by_id($id);
    }

    public function view()
    {
        $this->_mail_list = SalesMailFacade::get_all();
        $edit_id = SalesMailContext::EditID;
        $delete_id = SalesMailContext::DeleteBtnName;
    ?>
    <div class='new_btn_area'>
        <button class='manage_button' type='submit' name='<?php echo SalesMailContext::ContentID; ?>' >メール設定</button>
        <button class='manage_button' type='submit' name='<?php echo SalesMailContext::NewID; ?>'>新しくメールアドレスを追加する</button>
    </div>
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
					<?php echo "<button class='manage_button' type='submit' name='$delete_id' value='$m->id'>削除</button>"; ?>
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