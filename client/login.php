<?php 
include('header.php');
redirect_https();

if(isset($_SESSION['id']))
{

header('dashboard.php');
	
	
}

if(isset($_POST['submit']))
{

  $email = $_POST['email'];
  $password = $_POST['password'];
 
$error = '';
$message ='';
 
 
 if($email=='' and $password=='')
 {
	
    $error.= 'Please enter email id and password';
	
  }else{
	  
	  
	  $sql_query =("select * from user where email ='$email' and password = '$password'");
		$result = mysql_query($sql_query);
		$row = mysql_fetch_assoc($result);
		
		if(!empty($row))
		{
		
		  $_SESSION['id'] = $row['id'];
		  $_SESSION['type'] = $row['type'];
		  $_SESSION['name'] = $row['name'];
		  $_SESSION['LAST_ACTIVITY_step1'] = time(); // the start of the session.
	
		 
		  
		  if($_SESSION['type']=='S')
		  {
			 
			 
			 
			  
			 header('location:dashboard.php');  			  
		   }else{	
		   
	   
			 header('location:client.php');
			   
			}
		  
		  
		}else{
			
			  $error.= 'Wrong email or password';
				
		}
	  
	  
	  
	  } 





 
 
 
  
	
	
}




?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Login</title>
<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<link rel="stylesheet" href="colorbox/colorbox.css" />
<style>
body {
    position: absolute;
    width: 100%;
    background-color: #fff;
}
.frm_buttons, .frm_cont_top, .frm_cont_range {
    padding: 10px;
}
.frm_buttons, .frm_cont_range {
    border-top: 1px solid #d9d9d9;
}
</style>
</head>
<body>

<form method="post" action="">
	<center >
	<div class="login-container">
	<div class="login-head">
		<div class="desc-title"><strong>Client Management Centre</strong></div>
	</div>
	<div class="login-body">
	<table class="pop-up-table">
        <tr>
        	<td valign="top" class="tbl_label">Email Address: </td>
            <td><input type="text" name="email" id="email" value="<?php if(isset($email)){echo $email;} ?>" />
            </td>        
        </tr>
        
        <tr>
        	<td valign="top" class="tbl_label">Password: </td>
            <td><input type="password" name="password" id="password" value="" />
            <br/>
            
            </td>        
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" id="submit" value="Login" /></td>
		</tr>
    </table>
    </div>
   <div style="color:blue;" align="center">

<?php

if(isset($error)){echo $error;}

?>

</div> 
    </div>
    </center>
</form>
</body>
</html>