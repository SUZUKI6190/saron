<?php
namespace ui\customer;
use \business\facade\Customer;

class ErrObjEmptyEmail extends ErrObjBase
{
	public function view_err_msg()
    {
        ?>
        <span>emailが未入力です</span><br>
        <?php
    }
}

?>