<?php
namespace business\facade;
use \business\entity\ScheduledMessage;

class ScheduledMessageFacade
{
	private function __construct()
	{
	}

    public static function get_message_list()
    {
        $password = Customer::GetPassword();
        $strSql = <<<SQL
select
	m.title as title,
	m.message_text as text, 
	convert(AES_DECRYPT(c.email, '$password')  using utf8) as email
from
	yoyaku_customer as c,
	yoyaku_sending_message as m
where (m.staff_id is NULL or m.staff_id = c.tanto_id)
and (m.sex is NULL or m.sex = convert(AES_DECRYPT(c.sex, '$password') using utf8))
and (m.birth is NULL or (DATEDIFF(Now(), convert(AES_DECRYPT(c.birthday, '$password') using utf8)) - m.birth) = 0)
and (m.last_visit is NULL or (DATEDIFF(Now(), convert(AES_DECRYPT(c.last_visit_date, '$password') using utf8)) - m.last_visit) = 0)
and (m.occupation is NULL or m.occupation = convert(AES_DECRYPT(c.occupation, '$password')  using utf8))
and (m.visit_num_more is null or m.visit_num_less is null or (m.visit_num_more <= c.number_of_visit and m.visit_num_less >= m.visit_num_less))
and (m.enable_dm is NULL or m.enable_dm = c.enable_dm)
and (m.next_visit is NULL or (DATEDIFF(Now(), convert(AES_DECRYPT(c.next_visit_reservation_date, '$password') using utf8)) - m.next_visit) = 0)
and (m.reservation_route is NULL or m.reservation_route = convert(AES_DECRYPT(c.reservation_route, '$password')  using utf8))
SQL;

        global $wpdb;
        $result = $wpdb->get_results($strSql);
        
        $convert = function($data)
        {
            return ScheduledMessage::CreateFromWpdb(($data);
        };

	    return array_map($convert, $result);
    }

}

?>