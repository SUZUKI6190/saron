<?php
namespace ui\send_message\sub_category;
require_once(dirname(__FILE__).'/criteria.php');
require_once(dirname(__FILE__).'/timing-criteria.php');

function criteria_factory(int $page_no) 
{

    switch($page_no)
    {
        case 0:
            return [];
            break;
        case 1:
            return [
                new BirthVisitCriteria(),
                new LastVisitCriteria(),
                new NextVisitCriteria()
            ];
            break;
        case 2:
            return [];
            break;
    }
}

?>