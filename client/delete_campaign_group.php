<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

$id = $_GET['id'];
$client_id = $_GET['client_id'];




$sql_query = "DELETE  FROM group_campaign WHERE  	group_campaign_id='$id' and client_id = '$client_id' ";

$result = mysql_query($sql_query);


$sql_query = "DELETE  FROM group_campaign_link WHERE  	group_campaign_id='$id' and client_id = '$client_id' ";

$result = mysql_query($sql_query);






$_SESSION['msg']="Campaign Group Deleted Successfully";

header('location:campaign_group_list.php?client_id='.$client_id);

?>
