<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

$id = $_GET['id'];

$sql_query = "DELETE  FROM user WHERE id='$id'";

$result = mysql_query($sql_query);

$_SESSION['msg']="User Account Deleted Successfully";

header('location:user_list.php');

?>
