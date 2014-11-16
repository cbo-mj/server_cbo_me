<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

$id = $_GET['id'];

$sql_query = "DELETE  FROM email_notification WHERE notification_id='$id'";

$result = mysql_query($sql_query);

$_SESSION['msg']="Email notification has been deleted successfully";

header('location:email_notification.php');

?>
