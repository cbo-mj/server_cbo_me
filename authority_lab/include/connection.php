<?php

if($_SERVER["HTTP_HOST"]=="localhost")
{
	
	$user_name = "root";
	$host_name = "localhost";
	$password = "";
	$db_name = "shane_call_tracking";
	
	
	mysql_connect($host_name,$user_name,$password) or die ( mysql_error() );
	mysql_select_db($db_name) or die ( mysql_error() );
	
		
}else{
	
	$user_name = "cbouser";
	//$host_name = "23.229.132.67";
	$host_name = "localhost";
	$password = "call_tracking$2";
	$db_name = "call_tracking";
	
	mysql_connect($host_name,$user_name,$password) or die ( mysql_error() );
	mysql_select_db($db_name) or die ( mysql_error() );
	
	
}


$campaign_type = array();
$campaign_type[1] = 'Display';
$campaign_type[2] = 'Remarketing';
$campaign_type[3] = 'Campaign';
$campaign_type[4] = 'SEM';


?>