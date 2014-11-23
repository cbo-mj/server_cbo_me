<?php 
/*
	Created by abaam germones
	email : abaam@cbo.me or abaamgermones0727@gmail.com
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';


if (isset($_GET['ticketid']) == true) {
	$ticketid = $_GET['ticketid'];

	$Showticket = new CBOzendesk;
	$url = 'https://cbosupport.zendesk.com/api/v2/tickets/'.$ticketid.'/audits.json'; //tickets comments
	#$url = 'https://cbosupport.zendesk.com//api/v2/tickets/'.$ticketid.'.json?'; //per ticket details
	$res = $Showticket->curlprocess($url, $data = arraY(), $actiontype = 'getTicketDetails'); // It is important that you need to set the action type as getTicketDetails. Always check spelling and cammel back typo standard.

	echo json_encode($res);	
}else{	

	//DO SOME json for fail stuff message

}


?>