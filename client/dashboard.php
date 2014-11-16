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


/*print_r($_SESSION);
print_r('<pre>');*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Dashboard</title>
</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>


    <div align="center">
    
    	<br /><br />
    
    
        <a href="user_list.php">User List</a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a href="client.php">Client list</a><br /><br />
        
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="ga_index.php">Fetch Google Account and Property</a><br /><br />
         
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="gadwords_index.php">Fetch Adword customer account </a><br /><br />
         
          
         
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="adword_campaign.php"> Adword Campaign </a><br /><br />
         
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="icon.php">Icon list</a><br /><br />
         
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="service.php">Service list</a><br /><br />
         
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="email_notification.php">Email Notification list</a><br /><br />
         
         
         
    
    </div>

</body>
</html>