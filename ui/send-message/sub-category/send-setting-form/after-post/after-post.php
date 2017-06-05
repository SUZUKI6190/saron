<?php
namespace ui\send_message\sub_category;

abstract class MailSettingAfterPost
{
    protected abstract function pre_page_post_inner();
    
    public function init()
    {

    }

    public function pre_page_post_dealing()
    {
        $this->pre_page_post_inner();
    }
}


?>