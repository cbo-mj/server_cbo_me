<?php 
/*
	Created by abaam germones
	email : abaam@cbo.me or abaamgermones0727@gmail.com
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';


if (isset($_GET['id']) == true) {
	$zenid = $_GET['id'];

	$Showticket = new CBOzendesk;
	$url = 'https://cbosupport.zendesk.com/api/v2/users/'.$zenid.'.json';
	$res = $Showticket->curlprocess($url, $data = arraY(), $actiontype = 'getTicketDetails'); // It is important that you need to set the action type as getTicketDetails. Always check spelling and cammel back typo standard.

	echo json_encode($res);	
}else{

	//DO SOME json for fail stuff message

}


?>