<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

$service_id = $_GET['id'];

$sql_query = "DELETE  FROM services WHERE service_id='$service_id'";

$result = mysql_query($sql_query);

$_SESSION['msg']="Service Deleted Successfully";

header('location:service.php');

?>
