<?php
namespace ui\customer;
use \business\facade\Customer;

class ErrObjEmptyKanji extends ErrObjBase
{
	public function view_err_msg()
    {
        ?>
        <span>氏名(漢字)が未入力です。</span><br>
        <?php
    }
}

?>