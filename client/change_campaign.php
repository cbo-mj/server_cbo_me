<?php
include("include/connection.php");
include("include/common_function.php");
$campaign_id = $_GET["campaign_id"];
$id = $_GET["id"];
$client_id = $_GET["client_id"];
$phone_number = $_GET["phone_number"];
$sql_update_client = "update  client set
							  campaign_id = '$campaign_id' 							 
							  where 
									client_id = '$client_id'
									and id = '$id'
							";
mysql_query($sql_update_client) or die ( mysql_error() );	
$sql_update = "update call_log set
							campaign_id = '$campaign_id' 							 
							where target_number = '$phone_number'							
							";
mysql_query($sql_update) or die ( mysql_error() );	
echo 1;
?>