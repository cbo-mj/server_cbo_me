<?php
ob_start();
require('./includes/header1.php');
if(isset($_GET['status']) && !empty($_GET)){
header('location:'.URL_SITE.'/listing.php');
exit;
}else{
$tag = $_SESSION['tag'];
header('location:'.URL_SITE.'/listing.php?tag='.$tag);
}
?>


