<?php 
set_time_limit ( 120 );
include 'cbo-team-work-api.php';
            
$timelog = new CBOteamWork;

$twIDs = array("tw.133882.2012005",
"tw.133882.2012108",
"tw.133882.1992290",
"tw.133882.1478230",
"tw.133882.1968164"); //change this 

$jsonResult = array();

foreach ($twIDs as $key => $value) {

	$str = $value;

	list($r1, $r2, $taskId) = split('[.]', $str); //get TaskID

	$res = $timelog->ticketTimeEntry($taskid);

	 $jsonResult[] = $res;
}

echo json_encode($jsonResult);


?>