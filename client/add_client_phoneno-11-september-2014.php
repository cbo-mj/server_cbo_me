<?php
session_start();


if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}

include("include/connection.php");
include("include/common_function.php");
LAST_ACTIVITY();
redirect_https();

$client_id = $_GET["id"];

$error = array();
if(isset($_POST["submit"]))
{
	
	
	$target_number = $_POST["target_number"];
	
	if($_POST["target_number"]=="")
	{
		$error["target_number"] = "Please enter phone number !";
	}else{
		
		$sql_check = "select * from client where phone_number = '$target_number' ";	
		
		$rs_target_number = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_target_number) > 0 )
		{
			$error["target_number"] = "Already exits phone number !";	
		}
		
		
	}
	
	if(empty($error))
	{
		
		// add in db and send mail with link to admin
		
		
		
		$destination_number = $_POST["destination_number"];
		$target_name = $_POST["client_name"];
		$created_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			$sql_insert = "insert into client set
							client_id = '$client_id' ,							
							phone_number = '$target_number' ,
							destination_number = '$destination_number' ,
							created_date_time = '$created_date_time' ,
							mail_status = '1',
							created_by = '2'
							";
			
			mysql_query($sql_insert) or die ( mysql_error() );	
			
			$client_id = $target_number;
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				$url = "http://localhost/project/shane/call_tracking/index.php?id=$target_number";
				
			}else{
				$url = "server.cbo.me/call_tracking/index.php?id=$target_number";
			}
			
			$subject = "New Client Call Tracking Detail - $target_name";
			
			$shane = "shane.mcgeorge@cbo.me";
			$dale = "dale.mcgeorge@cbo.me";
			$anshuman_email = "anshuman.saraswat@gmail.com";
			$kamal_email = "kamalchoudharyindia@gmail.com";
			$message = '';
			ob_start();
			//include('email_body_new_client.php');			 
			include('email_body_new_client.php');			 
			$message = ob_get_clean();
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				//echo "<br/> <br/>";
				//echo $message;
			}
			
			$msg = "New phone number has been added successfully";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			
			
			/*@mail($kamal_email,$subject,$message,$headers);
			@mail($anshuman_email,$subject,$message,$headers);
			
			@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);		*/
		
			
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Client</title>
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
}
.frm_buttons, .frm_cont_top, .frm_cont_range {
    padding: 10px;
}
.frm_buttons, .frm_cont_range {
    border-top: 1px solid #d9d9d9;
}
form {
    margin: 0 !important;
}
</style>
</head>
<body>
<form method="post">
   <div class="item_modals">
   <h1 class="item-title">Add a Phone Number</h1>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table class="pop-up-table">
        <tr>
        	<td valign="top" class="tbl_label">Advertised Number:</td>
            <td><input type="text" name="target_number" id="target_number" value="<?php if($_POST["target_number"]){ echo $_POST["target_number"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["target_number"])){ echo $error["target_number"]; }?></span>
            </td>        
        </tr>
        <tr>
        	<td valign="top" class="tbl_label">Destination Number:</td>
            <td><input type="text" name="destination_number" id="destination_number" value="<?php if($_POST["destination_number"]){ echo $_POST["destination_number"];} ?>" /></td>        
        </tr>    
    </table>
	</div>
	<div class="frm_buttons"><input type="submit" name="submit" class="active_btn" id="submit" value="Add Number" /></div>
</form>
</body>
</html>