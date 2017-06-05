<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/after-post.php');
require_once(dirname(__FILE__).'/customer-criteria-after-post.php');
require_once(dirname(__FILE__).'/mail-content-after-post.php');
require_once(dirname(__FILE__).'/timing-criteria-ahter-post.php');

function create_after_post(int $page_no) : MailSettingAfterPost
{
    $mail_post_list = [
        new MailContentAfterPost(),
        new TimingCriteriaAfterPost(),
        new CustomerCriteriaAfterPost()
    ];

    return $mail_post_list[$page_no];
}

?>