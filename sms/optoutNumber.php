<?php require_once('header.php');?>
<?php require_once('api1.php');?>
<?php

$id = (int) $_GET['id'];
$list_id = (int) $_GET['list_id'];
$totmsg = (int) $_GET['totmsg'];
$msg = (string) $_GET['msg'];
$date = (string) $_GET['date'];
$from = (string) $_GET['from'];

// execute request
$methodResponse = $api->optoutContactListRecipient($_GET['list_id'], $_GET['mobile']);

// parse response into xml object
$xml = @simplexml_load_string($methodResponse);

// problem with request 
if (! $xml) { 
	$resmsg = date("y-m-d H:i:s") . " - Problem with request : " . $methodResponse;
}

// valid response has come back
else {
	
	// view contents of the request in raw dump form
	$resmsg = $xml->result;
	
}
	exit(header("Location: report.php?y=".$_GET['y']."&resmsg=".$resmsg."&totmsg=".$totmsg."&id=".$id."&msg=".$msg."&date=".$date."&from=".$from));
?>
<?php ob_flush(); ?> 