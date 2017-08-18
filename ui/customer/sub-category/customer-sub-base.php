<?php
namespace ui\customer;
use \SplFileObject;
use \business\entity\Config;
use \business\facade;

require_once(dirname(__FILE__).'/search/search-sub.php');
require_once(dirname(__FILE__).'/regist-new/regist-new-sub.php');
require_once(dirname(__FILE__).'/delete/delete-sub.php');
require_once(dirname(__FILE__).'/mass-registration/mass-registration-sub.php');

abstract class CustomerSubBase extends \ui\frame\SubCategory
{
	public function __construct()
	{
	}

	public function init()
	{
		
	}
}


?>