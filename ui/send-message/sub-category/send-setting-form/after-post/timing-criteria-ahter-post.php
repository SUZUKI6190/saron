<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/criteria-after-post.php');

class TimingCriteriaAfterPost extends CriteriaAfterPost
{
    protected  function on_set_criteria(Criteria $c)
    {
        if($c->is_set_criteria()){
            $c->clear_criteria();
        }
    }
}

?>