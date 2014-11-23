<?php 
/*
	Created by : Abaam Germones
	last update : 11/18/14
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';
include 'cbo-team-work-api.php';
//you can add more error trapping here
$submitter_id = $_GET['userid'];

$Showticket = new CBOzendesk;
#$url = 'https://cbosupport.zendesk.com/api/v2/tickets/ccd.json?submitter_id='.$submitter_id;
$url = 'https://cbosupport.zendesk.com/api/v2/users/'.$submitter_id.'/tickets/requested.json';
$res = $Showticket->curlprocess($url, $data = array(), $actiontype = 'listAll');

$teamwork = new CBOteamWork;
$timeRef = array('projects' => array());
foreach ($res->tickets as $key => $value) {
	
	
	//$res->tickets[$key]->timelogs = array('non-billable'=> 2121);// inserting new object array on object array
	#var_dump($value->tags);
	if(count($value->tags) > 0){
		foreach ($value->tags as $key2 => $value2) {
			
			$subject = $value2;
			$pattern = '/tw.([0-9]+).([0-9]+)/';
			
			if(preg_match($pattern, $subject, $matches) == true){ //check if task have TW relationshipt tags
				
				list($r1, $r2, $taskId) = split('[.]', $subject); //get TaskID
				
				//DO THE TEAMWORK HERE
				$tm = $teamwork->ticketTimeEntry($taskId);
			
				$res->tickets[$key]->timelogs = $tm;// inserting new object array on object array
				

				$taskListID = $tm->projects[0]->tasklist->id;
				
				$timeTasklist = $teamwork->getTimeLogTaskListByID((int)$taskListID);

				/*
				if(!isset($timeRef[$timeTasklist->projects[0]->id])){
					//Thiw will check if company name already in the array if not we will add them.
					$timeRef[$timeTasklist->projects[0]->company->id] = $timeTasklist;
					$timeRef[$timeTasklist->projects[0]->company->id] = array('company'=>$timeTasklist->projects[0]->company->name);
					$timeRef[$timeTasklist->projects[0]->company->id] = array('projects'=> array('name'=> $timeTasklist->projects[0]->name, 'tasklist'=> $timeTasklist->projects[0]));
					#exit;
				}
				*/
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