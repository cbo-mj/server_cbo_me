<?php 
/*
	Created by : Abaam Germones
	last update : 11/20/14
*/
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';

//you can add more error trapping here
$submitter_id = $_GET['userid'];

$Showticket = new CBOzendesk;
$open = 0;
$pending = 0;
$url = 'https://cbosupport.zendesk.com/api/v2/search.json?query=requester:'.$submitter_id.'+type:ticket';

$res = $Showticket->curlprocess($url, $data = array('status'=> 1), $actiontype = 'GET');
#echo '<pre>';
#var_dump($res);
foreach ($res->results as $key => $value) {
	if($value->status == "open"){
		$open++;
	}

	if($value->status == "pending"){
		$pending++;
	}
}

echo json_encode(array('open'=> $open, 'pending'=>$pending));


?>