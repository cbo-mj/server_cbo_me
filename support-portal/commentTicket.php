<?php 
/*
	Creadted by abaam Germones
	Make things simple :)
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';

$ticket = new CBOzendesk;

$postdata = $_POST;

$postData2 = $_FILES;

$attachDetails = $ticket->uploadAttachment($postData2);

$ticket->commentTicket($postdata, $attachDetails = array());

?>