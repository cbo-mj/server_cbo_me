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


$error = array();
$msg ="";
if(isset($_POST["submit"]))
{
	
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	
	if($name=="")
	{
		
	$error["name"] = "Please enter your  name!";	
		
	}
	
	if($email=="")
	{
		$error["email"] = "Please enter email id !";
		
	}else{
		
		
		 if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		  {
		  $error['email'] =  "E-mail is not valid";
		  }else{
		
		$sql_check = "select * from user where email ='$email'";	
		
		$rs_email = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_email)>0)
		{
		$error["email"] = "Already exits  Email id !";
				
		}
		
	}
	  		 
	}
	
		if($password=='')
		
		{
		
		$error['password'] = "Please enter password !";	
			
		}
	
	if(empty($error))
	{
		
		// add in db and send mail with link to admin
		
		$created_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			 $sql_insert = "insert into user set
							name = '$name',
							email = '$email',
							password = '$password',
							created_date_time = '$created_date_time'
							";
			mysql_query($sql_insert) or die (mysql_error());	
			
			$msg = "New user has been added successfully";
			$_POST ='';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Add User</title>
</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" action="">
	<p><strong>Add User</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table >
       <tr>
        	<td valign="top">Name</td>
            <td><input type="text" name="name" id="name" value="<?php if($_POST["name"]){ echo $_POST["name"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["name"])){ echo $error["name"];}?></span>
            </td>        
        </tr>
        
        <tr>
        	<td valign="top">Email</td>
            <td><input type="text" name="email" id="email" value="<?php if($_POST["email"]){ echo $_POST["email"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["email"])){ echo $error["email"]; }?></span>
            </td>        
        </tr>
        
         <tr>
        	<td valign="top">Password</td>
            <td><input type="password" name="password" id="password" value="<?php if($_POST["password"]){ echo $_POST["password"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["password"])){ echo $error["password"]; }?></span>
            </td>        
        </tr>
        
        
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Add User" /></td>        
        </tr>
    </table>
</form>
</body>
</html>