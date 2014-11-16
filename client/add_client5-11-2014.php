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
?>

<script type="text/javascript">
function reload_page()
{
	window.top.location.reload();
}
</script>
<?php
$error = array();
if(isset($_POST["submit"]))
{
	if($_POST["client_name"]=="")
	{
		$error["client_name"] = "Please enter client name !";
	}
	
	$target_number = $_POST["target_number"];
	
	/*if($_POST["target_number"]=="")
	{
		$error["target_number"] = "Please enter phone number !";
	}else{
		
		$sql_check = "select * from client where phone_number = '$target_number' ";	
		
		$rs_target_number = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_target_number) > 0 )
		{
			$error["target_number"] = "Already exits phone number !";	
		}
		
		
	}*/
	
	if($_POST["target_number"]!="")
	{
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
		
		$rand_number =  mt_rand(10, 500000000);
		$client_id = time()."".$rand_number;
		
		
		
		$target_name = $_POST["client_name"];
		$created_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			$sql_insert = "insert into client set
							client_id = '$client_id' ,
							client_name = '$target_name' ,
							phone_number = '$target_number' ,
							created_date_time = '$created_date_time' ,
							mail_status = '1',
							created_by = '2'
							";
			mysql_query($sql_insert) or die ( mysql_error() );	
			
			$sql_update = "update call_log set
						client_id = '$client_id' 
						where target_number = '$target_number'
						";
		    mysql_query($sql_update) or die ( mysql_error() );	
			
			
			
			$_POST['admin_submit_form'] = '1';
			
			
			//$target_number = $target_number;
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				$url = "http://localhost/project/shane/live/client/dashboard.php?id=$client_id";
				
			}else{
				$url = "server.cbo.me/calls/dashboard.php?id=$client_id";
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
			
			$msg = "New client has been added successfully";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			
			
			@mail($kamal_email,$subject,$message,$headers);
			@mail($anshuman_email,$subject,$message,$headers);
			
			@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);	
			
			echo '<script type="text/javascript">
			
				
				reload_page();
				
			   </script>';	
		
			
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
#submit {
    background: -moz-linear-gradient(center top , #179DFE 0%, #0461D2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#461d2), to(#0179dfe));
	background: -webkit-linear-gradient(top, #179dfe, #0461d2);
	background: -ms-linear-gradient(top, #179dfe, #0461d2);
	background: -o-linear-gradient(top, #179dfe, #0461d2);
    border: medium none;
	border-radius: 3px;
    color: #FFFFFF;
    font-weight: 600;
    margin-right: 10px;
    padding: 3px 10px;
    position: relative;
	font-size: 14px;
    text-shadow: 0 -1px 0 #0453C9;
}
form {
    margin: 0 !important;
}
</style>
</head>
<body>
<form method="post">
   <div class="item_modals">
   <h1 class="item-title">Add Client</h1>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table class="pop-up-table">
        <tr>
        	<td valign="top" class="tbl_label">Name:</td>
            <td><input type="text" name="client_name" id="client_name" value="<?php if($_POST["client_name"]){ echo $_POST["client_name"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["client_name"])){ echo $error["client_name"]; }?></span>
            </td>        
        </tr>
        <tr>
        	<td valign="top" class="tbl_label">Phone Number:</td>
            <td><input type="text" name="target_number" id="target_number" value="<?php if($_POST["target_number"]){ echo $_POST["target_number"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["target_number"])){ echo $error["target_number"]; }?></span>
            </td>        
        </tr>
    </table>
	</div>
<div class="frm_buttons"><input type="submit" name="submit" id="submit" value="Add Client" /></div>
</form>
</body>
</html>