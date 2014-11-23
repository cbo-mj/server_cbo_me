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
	$res = $Showticket->curlprocess($url, $data = array(), $actiontype = 'getTicketDetails'); // It is important that you need to set the action type as getTicketDetails. Always check spelling and cammel back typo standard.

	
	//GET USER DETIALS
	$c = 0;
	foreach ($res->audits as $key => $value) {
		
			
		if(isset($value->events[0]->author_id) == TRUE){
			$zendUserId = $value->events[0]->author_id;	
			$url2 = 'https://cbosupport.zendesk.com/api/v2/users/'.$zendUserId.'.json';
			$res2 = $Showticket->curlprocess($url2, $data = array(), $actiontype = 'get'); 
			
			unset($res2->user->role);
			$res->audits[$key]->events[0]->author_info = $res2->user;
			unset($res2);//thsi will reduce load to the memory
			#echo json_encode($res->audits[$key]->events[0]->author_info);
		}
		
	}

	echo json_encode($res);
	
}else{

	//DO SOME json for fail stuff message

}


?>