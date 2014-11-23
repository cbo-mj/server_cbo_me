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
	
	$icon_name = $_POST["icon_name"];
	$description = $_POST["description"];
	$date = $_POST["date"];
	$client_id = $_POST["client_id"];
	
	$event_type =  $_POST["event_type"];
	
	
	if($icon_name=="")
	{
		
		$error["icon_name"] = "Please enter icon name !";	
		
	}
	
	if($event_type=="")
	{
		
		$error["event_type"] = "Please select event type !";	
		
	}
	
	
		
	
	if(empty($error))
	{
		
		// add in db and send mail with link to admin
		
		$created_date_time = date("Y-m-d H:i:s");
		
		
		// not need to insert	and send mail		
			 $sql_insert = "insert into ga_icon_display set
							icon_name = '$icon_name',
							date = '$date',
							client_id = '$client_id',
							description = '$description',
							event_type = '$event_type',
							created_date_time = '$created_date_time'
							";
			mysql_query($sql_insert) or die (mysql_error());	
			
			
			$_POST ='';
			$_SESSION['msg']= $msg;
			header('location:icon.php');

	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Add Icon</title>

<link rel="stylesheet" href="date_picker/jquery-ui.css" />

<script src="date_picker/jquery-1.9.1.js"></script>

<script src="date_picker/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  { 
	
	$( "#date" ).datepicker({
	  dateFormat: 'yy-mm-dd' ,	
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	
	
  }
  

);

</script>



</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" action="">
	<p><strong>Add Icon</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table>
    
    <?php
    $sql_client = "select * from client where client_name!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
    
    
	 
	
						
	?>
    
    <tr>
        	<td valign="top" class="tbl_label">Client</td>
            <td>
            <select name="client_id"  style="border:1px solid #979393;">
        <option value="">All Client</option>        
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
            
            </td>        
        </tr>
    
    
       <tr>
        	<td valign="top">Date</td>
            <td><input type="text" name="date" id="date" value="<?php if($_POST["date"]){ echo $_POST["date"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["date"])){ echo $error["date"];}?></span>
            </td>        
        </tr>
       
       <tr>
        	<td valign="top">Icon Name</td>
            <td><input type="text" name="icon_name" id="icon_name" value="<?php if($_POST["icon_name"]){ echo $_POST["icon_name"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["icon_name"])){ echo $error["icon_name"];}?></span>
            </td>        
        </tr>
        
         <tr>
        	<td valign="top" class="tbl_label">Event Type</td>
            <td>
            
            <?php
			$event_type_arr = array();
			$event_type_arr['flag'] = 'flag';
			$event_type_arr['sign'] = 'sign';
			$event_type_arr['pin'] = 'pin';
			$event_type_arr['triangleUp'] = 'triangleUp';
			$event_type_arr['triangleDown'] = 'triangleDown';
			$event_type_arr['triangleLeft'] = 'triangleLeft';
			$event_type_arr['triangleLeft'] = 'triangleRight';
			$event_type_arr['triangleLeft'] = 'text';
			$event_type_arr['triangleLeft'] = 'arrowUp';
			$event_type_arr['triangleLeft'] = 'arrowDown';
			?>
            
            
            <select name="event_type"  style="border:1px solid #979393;">
        <option value="">Please select event type</option>        
     <?php
	
	
	 foreach($event_type_arr as $key=>$value)
	 {
		 $selected_event_type = '';
		 if($value==$_POST['event_type'])
		 {	
		 	$selected_event_type = 'selected="selected"';
			
		 }
		 
		 
	?>
		<option  <?php echo $selected_event_type;?>  value="<?php echo $value;?>"><?php echo $value;?></option>
	
    
    <?php
	}

	?>	
    </select>
    
     <br/>
            <span style="color:blue;"><?php if(isset($error["event_type"])){ echo $error["event_type"];}?></span>
            
            </td>        
        </tr>
        
        
        <tr>
        	<td valign="top">Description</td>
            <td>
            
            
            <textarea style="height:100px; width:300px;" type="text" name="description" id="description"><?php if($_POST["description"]){ echo $_POST["description"];} ?></textarea>
            <br/>
            <span style="color:blue;"><?php if(isset($error["description"])){ echo $error["description"];}?></span>
            </td>        
        </tr>
       
        
        
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Add" /></td>        
        </tr>
    </table>
</form>
</body>
</html>