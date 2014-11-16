<?php
session_start();


if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}

include("include/connection.php");
include("include/common_function.php");
LAST_ACTIVITY();
redirect_https();

if(isset($_GET["cpid"]) and $_GET["cpid"]!="" )
{
	$client_id = $_GET["id"];
	$cpid = $_GET["cpid"];
	$sql_delete = "delete from campaign where campaign_id = '$cpid' and client_id = '$client_id' ";
	$rs_client = mysql_query($sql_delete) or die ( mysql_error() );	
	
	$sql_update = "update call_log set campaign_id = '' where campaign_id = '$cpid' ";
	 mysql_query($sql_update) or die ( mysql_error() );	
	 
	
							
	$_SESSION["delete_msg"] = "Campaign has been deleted";
	header("location:campaign.php?id=$client_id");	
}else{
	header("location:campaign.php");	
	die;
}
?>