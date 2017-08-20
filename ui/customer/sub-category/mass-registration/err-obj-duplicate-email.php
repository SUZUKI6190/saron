<?php
namespace ui\customer;
use \business\facade\Customer;

class ErrObjDuplicateEmail extends ErrObjBase
{
	public function view_err_msg()
    {
        ?>
        <span>重複したemailです</span><br>
        <?php
        $email = $this->_customer->email;
        echo "<span>$email;</span>";
    }
}

?>