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


if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}

$service_id = $_GET['id'];
if($service_id=='')
{
	header("location:service.php");	
}

$sql_query = "SELECT * FROM services WHERE service_id = '$service_id' ";

$result = mysql_query($sql_query);

$service_detail = mysql_fetch_assoc($result);

$error = array();
$msg ="";
if(isset($_POST["submit"]))
{
	
	$service_name = mysql_escape_string($_POST["service_name"]);
	$updated_dtm = date("Y-m-d H:i:s");
	
	
	
	
	
	if($service_name=="")
	{
		
		$error["service_name"] = "Please enter service name !";	
		
	}else{
		
		$sql = "select * from services where service_name = '$service_name' and service_id != '$service_id' ";
		$rs_service = mysql_query($sql) or die ( mysql_error() );
		$total_services = mysql_num_rows($rs_service);
		if($total_services > 0 )
		{
			$error["service_name"] = "Service name already exits !";		
		}
			
	}
	

		
	
	if(empty($error))
	{
			 $sql_update = " update services set
								service_name = '$service_name',
								updated_dtm = '$updated_dtm' 
								
							WHERE service_id = '$service_id'
							
							";
			mysql_query($sql_update) or die (mysql_error());	
			
			$msg = "Service has been updated successfully";
			
			$_POST ='';
			$_SESSION['msg']= $msg;
			header('location:service.php');

	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Edit Service</title>




</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" action="">
	<p><strong>Edit Service</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table>
       
       <tr>
        	<td valign="top">Service Name</td>
            <td><input type="text" name="service_name" id="service_name" value="<?php if($_POST["service_name"]){ echo $_POST["service_name"];}else{ echo $service_detail['service_name'];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["service_name"])){ echo $error["service_name"];}?></span>
            </td>        
        </tr>
        
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Add" /></td>        
        </tr>
    </table>
</form>
</body>
</html>