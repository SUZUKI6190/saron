<?php
namespace ui\customer;
use \business\entity\Customer;

abstract class ErrObjBase
{
	protected $_customer;
	public abstract function view_err_msg();

	public function __construct(Customer $c)
	{
		$this->_customer = $c;

	}

}

?>