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
	
	$email = $_POST["email"];
	$client_id = $_POST["client_id"];
	$service_id = $_POST["service_id"];
	
	
	
	if($email=="")
	{
		$error["email"] = "Please enter email !";	
	}
	
	if($service_id=="")
	{
		$error["service_id"] = "Please select service !";	
	}
	
	
	if($client_id=="")
	{
		$error["client_id"] = "Please select client !";	
	}
	
	if(empty($error))
	{
		$sql = "select * from email_notification where service_id = '$service_id' and client_id = '$client_id' ";
		$rs_email = mysql_query($sql) or die ( mysql_error() );
		$total_email = mysql_num_rows($rs_email);
		if($total_email > 0 )
		{
			$error["email"] = "Already assign email to service. please select other service or client !";		
		}	
	}
	

		
	
	if(empty($error))
	{
		
		
		$created_dtm  = date("Y-m-d H:i:s");
		
		$sql_insert = "insert into email_notification set
						email = '$email',
						client_id = '$client_id',
						service_id  = '$service_id ',
						created_dtm  = '$created_dtm '
						";
		 mysql_query($sql_insert) or die (mysql_error());	
			
		$msg = "Email notification has been added successfully";
			
		$_POST ='';
		$_SESSION['msg']= $msg;
		header('location:email_notification.php');

	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Add Email Notification</title>



</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" action="">
	<p><strong>Add Email Notification</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table>
    
    
    <?php
    $sql_services = "select * from services  ";
	$rs_service = mysql_query($sql_services) or die ( mysql_error() );							
	
						
	?>
    
    <tr>
        	<td valign="top" class="tbl_label">Service</td>
            <td>
            <select name="service_id"  style="border:1px solid #979393;">
        <option value="">Please select service</option>        
     <?php
	 
	
	if(mysql_num_rows($rs_service)>0)
	{
	 while($service_detail = mysql_fetch_assoc($rs_service))
	 {
		 $selected_acc = '';
		 if($service_detail["service_id"]==$_POST['service_id'])
		 {	
		 	$selected_acc = 'selected="selected"';
			
		 }
		 
		 
	?>
		<option  <?php echo $selected_acc;?>  value="<?php echo $service_detail['service_id'];?>"><?php echo $service_detail['service_name'];?></option>
	
    
    <?php
	}
}
	?>	
    </select>
    
    <br/>
            <span style="color:blue;"><?php if(isset($error["service_id"])){ echo $error["service_id"];}?></span>
            
            </td>        
        </tr>
    
    
    
    <?php
    $sql_client = "select * from client where client_name!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
						
	?>
    
    <tr>
        	<td valign="top" class="tbl_label">Client</td>
            <td>
            <select name="client_id"  style="border:1px solid #979393;">
        <option value="">Please select client</option>        
     <?php
	 
	
	if(mysql_num_rows($rs_client)>0)
	{
	 while($client_detail = mysql_fetch_assoc($rs_client))
	 {
		 $selected_acc = '';
		 if($client_detail["client_id"]==$_POST['client_id'])
		 {	
		 	$selected_acc = 'selected="selected"';
			
		 }
		 
		 
	?>
		<option  <?php echo $selected_acc;?>  value="<?php echo $client_detail['client_id'];?>"><?php echo $client_detail['client_name'];?></option>
	
    
    <?php
	}
}
	?>	
    </select>
    
    <br/>
            <span style="color:blue;"><?php if(isset($error["client_id"])){ echo $error["client_id"];}?></span>
            
            </td>        
        </tr>
    
    
      
       
       <tr>
        	<td valign="top">Email Notification</td>
            <td>
            
             <textarea style="height:100px; width:300px;" type="text" name="email" id="email"><?php if($_POST["email"]){ echo $_POST["email"];} ?></textarea>
            
        
            <br/>
            <span style="color:blue;"><?php if(isset($error["email"])){ echo $error["email"];}?></span>
            </td>        
        </tr>
        
       
        
        
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Add" /></td>        
        </tr>
    </table>
</form>
</body>
</html>