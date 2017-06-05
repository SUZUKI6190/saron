<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/criteria-after-post.php');

abstract class CriteriaAfterPost extends  MailSettingAfterPost
{
    private $_criteria_list;

    public function set_list($l)
    {
        $this->_criteria_list = $l;
    }

    protected abstract function on_set_criteria(Criteria $c);
    protected function pre_page_post_inner()
    {
        foreach($this->_criteria_list as $c)
        {
            $this->on_set_criteria($c);
        }   
        
    }
}

?>