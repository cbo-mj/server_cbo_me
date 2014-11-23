<?php
set_time_limit ( 120 );
require_once ("MysqliDb.php");
include 'cbo-team-work-api.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

	$user_name = "cbouser";
    //$host_name = "23.229.132.67";
    $host_name = "localhost";
    $password = "call_tracking$2";
    $db_name = "call_tracking";

$db = new Mysqlidb('localhost', $user_name, $password, $db_name);
if(!$db) die("Database error");
//------------------------------------

if(isset($_GET['clientid'])){

	$clientid = $_GET['clientid'];

	$cols = array('c.client_id',
				  'c.client_name',
				  'z.Zendesk_company_ID',
				  'z.Support_purchased',
				  'z.Support_provided',
				  'z.Support_available',
				  'z.Non_charged_support',
				  'z.Open_tickets',
				  'teamwork_id');

	$db->join('zendesk_info z', 'c.Zendesk_company_ID = z.Zendesk_company_ID');
	$db->where('c.client_id', $clientid);
	$company = $db->get ("client c", null, $cols);
	
	
	$projectIDs = explode("|", $company[0]['teamwork_id']);

	
	$teamwork = new CBOteamWork;
	$timelogs = array();
	$projects = array();

	if(count($projectIDs) > 0){ //just checking if there is a project ids
		foreach($projectIDs as $key=> $projID){
			//PROJECT LEVEL
			$TaskList = $teamwork->getTaskListByProjectID($projID);
			$taskLogs = array();
			foreach($TaskList as $key2=> $TL){
				//TODO OR TASKLIST LEVEL
			
				if(count($TL) > 0){
					for($x = 0; $x < count($TL); $x++ ) {

						$timePerTaskList = $teamwork->getTimeLogTaskListByID(@$TL[$x]->id);
							
							if(@$timePerTaskList->projects[0]->tasklist->name == 'SUPPORT TICKETS'){
								$taskLogs[] = $timePerTaskList;
							}
							/*
							foreach($timePerTaskList->projects as $key4=> $tasklistVal){
								
								if($timePerTaskList->projects[0]->tasklist->name) != 'SUPPORT TICKETS'){
									unset($timePerTaskList[$key3]);
								}
								
							}
							*/
							#exit;
							
						
						
					}
					
				}
					
					
			}

			
			$projects[] = $taskLogs;
			
		}
	}

	$company['timelogs'] = $projects;
	echo json_encode($company);
}else{

}

?>