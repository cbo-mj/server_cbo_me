<?php 
/*
	Created by : Abaam Germones
	last update : 11/20/14
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';
include 'cbo-team-work-api.php';

//you can add more error trapping here
$groupid = $_GET['groupid'];

$Showticket = new CBOzendesk;

$url = 'https://cbosupport.zendesk.com/api/v2/search.json?query=group_id:'.$groupid.'+created>2014-11-01+type:ticket&sort_order=desc&sort_by=status:open';

$res = $Showticket->curlprocess($url, $data = array(), $actiontype = 'GET');

$teamwork = new CBOteamWork;
$timeRef = array('projects' => array());

foreach ($res->results as $key => $value) {
	
	
	//$res->results[$key]->timelogs = array('non-billable'=> 2121);// inserting new object array on object array
	#var_dump($value->tags);
	if(count($value->tags) > 0){
		foreach ($value->tags as $key2 => $value2) {
			
			$subject = $value2;
			$pattern = '/tw.([0-9]+).([0-9]+)/';
			
			if(preg_match($pattern, $subject, $matches) == true){ //check if task have TW relationshipt tags
				
				list($r1, $r2, $taskId) = split('[.]', $subject); //get TaskID
				
				//DO THE TEAMWORK HERE
				$tm = $teamwork->ticketTimeEntry($taskId); //Get Ticket or task information from teamwork
			
				$res->results[$key]->timelogs = $tm;// inserting new object array on object array
				

				$taskListID = $tm->projects[0]->tasklist->id;
				
				$timeTasklist = $teamwork->getTaskListByID((int)$taskListID);

				
				if(!in_array($timeTasklist, $timeRef['projects'])){
					$timeRef['projects'][] = $timeTasklist;
				}

				unset($tm);
				unset($timeTasklist);	
				
				
			} //end if
		}//end of for each
	}
	
}

$res->time_reference = $timeRef;
echo json_encode($res);
?>