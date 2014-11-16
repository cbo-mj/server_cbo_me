<?php
include("include/connection.php");
include("include/common_function.php");
//pr($_GET);
$client_id = $_GET["client_id"];
$id = $_GET["id"];
$sql_update = "update call_log set
						client_id = '$client_id' 
						where caller_number = '$id'
						";
		mysql_query($sql_update) or die ( mysql_error() );	
echo 1;
?>