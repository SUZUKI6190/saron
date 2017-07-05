<?php
namespace ui\customer;
use business\entity\Customer;
require_once("customer-detail-item.php");

function  create_item_list(Customer $c)
{
	return [
		new KanjiNameDetailItem($c),
		new KanaNameDetailItem($c),
		new TellDetailItem($c),
		new MailDetailItem($c),
		new SexDetailItem($c),
		new OldDetailItem($c),
		new BirthDetailItem($c),
		new AddressDetailItem($c),
		new OccupationDetailItem($c),
		new NumberOfVisitDetailItem($c),
		new StaffDetailItem($c),
		new LastVisitDateDetailItem($c),
		new NextVisitReservationDateDetailItem($c),
		new ReservationRouteDetailItem($c),
		new EnableDMDetailItem($c),
		new RemarkDetailItem($c)
	];
}

?>