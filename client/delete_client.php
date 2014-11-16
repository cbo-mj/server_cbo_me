<?php
include("include/connection.php");
include("include/common_function.php");
session_start();
if(isset($_GET["id"]) and $_GET["id"]!="" )
{
	$client_id = $_GET["id"];
	
	$phone_number = $_GET['phone_number'];
	
	$sql_delete = "delete from client where client_id = '$client_id' and phone_number = '$phone_number' ";
	$rs_client = mysql_query($sql_delete) or die ( mysql_error() );	
	$sql_update = "update call_log set client_id = '' where client_id = '$client_id' ";
	mysql_query($sql_update) or die ( mysql_error() );	
	$_SESSION["delete_msg"] = "Client has been deleted";
	header("location:client.php");	
}else{
	header("location:client.php");	
	die;
}
?>