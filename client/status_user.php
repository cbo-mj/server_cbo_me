<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}


if(isset($_SESSION["type"]) and $_SESSION["type"]=="U")
{
	header("location:client.php");	
}


$id = $_GET['id'];
 $status = $_GET['status'];


$sql_query = "UPDATE  user set status ='$status' WHERE id='$id'";

$result = mysql_query($sql_query);

if($status=='A')
{
	$_SESSION['msg']="User Account Active Successfully";	
}

if($status=='D')
{
	$_SESSION['msg']="User Account Deactive Successfully";	
}

header('location:user_list.php');

?>
