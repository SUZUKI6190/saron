<?php
namespace ui\customer;
use \business\facade\Customer;

class ErrObjEmptyKana extends ErrObjBase
{
	public function view_err_msg()
    {
        ?>
        <span>氏名(かな)が未入力です。</span><br>
        <?php
    }
}

?>