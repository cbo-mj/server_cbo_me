<?php 
set_time_limit ( 120 );
include 'cbo-zendesk-api.php';

//you can add more error trapping here
#$submitter_id = $_GET['userid'];
#$submitter_page = isset($_GET['pagenum']) == true ?  $_GET['pagenum'] : 0;
$url = 'https://cbosupport.zendesk.com/api/v2/users.json';
 $Showticket = new CBOzendesk;
$res = $Showticket->curlprocess($url, $data = arraY(), $actiontype = 'listAll');
echo json_encode($res);

?> 


