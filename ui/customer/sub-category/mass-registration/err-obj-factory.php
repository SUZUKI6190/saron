<?php
namespace ui\customer;
use \business\entity\Customer;
require_once(dirname(__FILE__).'/err-obj-base.php');
require_once(dirname(__FILE__).'/err-obj-empty-kana.php');
require_once(dirname(__FILE__).'/err-obj-empty-kanji.php');
require_once(dirname(__FILE__).'/err-obj-empty-email.php');
require_once(dirname(__FILE__).'/err-obj-duplicate-email.php');

class ErrObjBaseFactory
{
	public static function create_err_obj(Customer $c) 
    {
        $ret = null;

        if(empty($c->email)){
            $ret = new ErrObjEmptyEmail($c);
        }else{            
            $result = \business\facade\select_customer_id_and_visitnum_by_email($c->email);
            if(is_null($result)){
                
            }else{
                $ret = new ErrObjDuplicateEmail($c);
            }
        }

        if(empty($c->name_kanji)){
            $ret = new ErrObjEmptyKanji($c);
        }

        if(empty($c->name_kana)){
            $ret = new ErrObjEmptyKana($c);
        }

        return $ret;
    }
}

?>