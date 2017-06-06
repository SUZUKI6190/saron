<?php
namespace ui\send_message\sub_category;

abstract class MailSettingAfterPost
{
    protected abstract function pre_page_post_inner(Criteria $c);
    
    public function init()
    {

    }

    public function pre_page_post_dealing(Criteria $c)
    {
        $this->pre_page_post_inner($c);
    }
}


?>