<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/after-post.php');

class CustomerCriteriaAfterPost extends MailSettingAfterPost
{
    protected function pre_page_post_inner(Criteria $c)
    {

    }
}

?>