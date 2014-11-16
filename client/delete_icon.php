<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

$id = $_GET['id'];

$sql_query = "DELETE  FROM ga_icon_display WHERE icon_id='$id'";

$result = mysql_query($sql_query);

$_SESSION['msg']="Icon Deleted Successfully";

header('location:icon.php');

?>
