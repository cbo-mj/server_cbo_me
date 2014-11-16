<?php
include('header.php');

if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}

if(isset($_SESSION["type"]) and $_SESSION["type"]=="U")
{
	header("location:client.php");	
}

$id = $_GET['id'];

$sql_query = "SELECT * FROM user WHERE id='$id'";

$result = mysql_query($sql_query);

$row = mysql_fetch_assoc($result);

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
		
		$sql_check = "select * from user where email ='$email' and id !='$id'";	
		
		$rs_email = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_email)>0)
		{
		$error["email"] = "Already exits  Email id !";
				
		}
		
	}
	  		 
	}
	
		$password_str = '';
		
		if($password=='')		
		{
			//$error['password'] = "Please enter password !";	
		}else{
			$password_str = " , password = '$password'  ";	
		}
	
	if(empty($error))
	{
		
		// add in db and send mail with link to admin
		
		$created_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			 $sql_update = "update  user set
							name = '$name',
							email = '$email'
							
							$password_str
							
							where id ='$id'
							";
			mysql_query($sql_update) or die (mysql_error());
			
				$sql_query = "SELECT * FROM user WHERE id='$id'";

				$result = mysql_query($sql_query);

				$row = mysql_fetch_assoc($result);
	
			
			$msg = "New user has been Update successfully";
			//header('location:user_list.php');
			
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Edit User</title>
</head>

<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" action="">
	
    <p><strong>Edit  User</strong></p>
    
    <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	
    <table >
     
       <tr>
        	<td valign="top">Name</td>
            <td><input type="text" name="name" id="name" value="<?php if(isset($row)){echo $row['name'];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["name"])){ echo $error["name"];}?></span>
            </td>        
        </tr>
        
        <tr>
        	<td valign="top">Email</td>
            <td><input type="text" name="email" id="email" value="<?php if(isset($row)){echo $row['email'];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["email"])){ echo $error["email"]; }?></span>
            </td>        
        </tr>
        
         <tr>
        	<td valign="top">Password</td>
            <td><input type="password" name="password" id="password" value="<?php if(isset($row)){echo $row['password'];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["password"])){ echo $error["password"]; }?></span>
            </td>        
        </tr>
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Update User" /></td>        
        </tr>
        
        
    </table>
    
</form>

</body>

</html>