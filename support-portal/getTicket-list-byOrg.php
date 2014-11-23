<?php 
/*
	Created by : Abaam Germones
	last update : 11/20/14
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';
include 'cbo-team-work-api.php';

//you can add more error trapping here
$orgid = $_GET['orgid'];

$Showticket = new CBOzendesk;

$url = 'https://cbosupport.zendesk.com/api/v2/organizations/'.$orgid.'/users.json';

$rs1 = $Showticket->curlprocess($url, $data = array(), $actiontype = 'GET'); //Get all users from org

$ticksets = array();


$teamwork = new CBOteamWork;

//This will trap if no users found
if(count($rs1->users ) < 1){
	echo json_encode(array('status'=> 'No users'));
	exit;
}


foreach($rs1->users as $key=> $user){
	//users Level
	$url = 'https://cbosupport.zendesk.com/api/v2/users/'.$user->id.'/tickets/requested.json';
	$res2 = $Showticket->curlprocess($url, $data = array(), $actiontype = 'GET');
	
	foreach ($res2->tickets as $key2 => $ticket) {
		//Ticket level
		if(count($ticket->tags) > 0){
			foreach ($ticket->tags as $key3 => $tag) {
				//TAGS level
				$subject = $tag;
				$pattern = '/tw.([0-9]+).([0-9]+)/';
				
				if(preg_match($pattern, $subject, $matches) == true){ //check if task have TW relationshipt tags
					
					list($r1, $r2, $taskId) = split('[.]', $subject); //get TaskID
					
					//DO THE TEAMWORK HERE
					$tm = $teamwork->ticketTimeEntry($taskId);
				
					$res2->tickets[$key2]->timelogs = $tm;// inserting new object array on object array
					

					unset($tm);
				
				}else{
					$res2->tickets[$key2]->timelogs = 0;
				}
			}//end of for each
		}
	}

	$ticksets[] = array('user_info'=> $user, 'tickets' => $res2);

	unset($res2);
}

echo json_encode($ticksets);

?>