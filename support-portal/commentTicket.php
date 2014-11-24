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

if(isset($_POST['mark_as_resolved']) == TRUE){
	if ($_POST['mark_as_resolved'] == "on") {
		$status = $_POST['ticket_status'];
	}
}else{
	$status = '';
}



$attachDetails = $ticket->uploadAttachment($postData2);

$ticket->commentTicket($postdata, $attachDetails = array(), $status);

?>