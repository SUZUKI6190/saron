<?php
namespace ui\sales;
use business\entity\SalesMail;
use business\facade\SalesMailFacade;

class SalesMailList implements ISalesMailViewer
{
    private $_mail_list;
    public $edit_btn_name;
    public $delete_btn_name;
    public  $new_btn_name;

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
    ?>
    <div class='new_btn_area'>
        <button class='manage_button' type='submit' name='<?php echo $this->new_btn_name; ?>' value=''>新しく追加する</button>
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
					<?php echo "<button class='manage_button' type='submit' name='$this->edit_btn_name' value='$m->id'>編集</button>"; ?>
				</td>
				<td class='cmd_td'>
					<?php echo "<button class='manage_button' type='submit' name='$this->delete_btn_name' value='$m->id'>削除</button>"; ?>
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