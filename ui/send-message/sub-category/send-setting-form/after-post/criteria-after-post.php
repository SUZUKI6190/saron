<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/criteria-after-post.php');

abstract class CriteriaAfterPost extends  MailSettingAfterPost
{
    protected abstract function on_set_criteria(Criteria $c);

    protected function pre_page_post_inner(Criteria $c)
    {
        $this->on_set_criteria($c);
    }
}

?>