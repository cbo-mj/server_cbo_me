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

if(isset($_GET["id"]) and $_GET["id"]!="" )
{
	$id = $_GET["id"];
	$client_id = $_GET["client_id"];
	$phone_number = $_GET["phone_number"];
	
	$sql_client = "select * from client where client_id = '$client_id' and phone_number = '$phone_number' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
			
	}else{
		header("location:client.php");	
		die;
	}
	
	
	$sql_client_acc = "select * from client where client_id = '$client_id' and account_id!='' ";
	$rs_client_acc = mysql_query($sql_client_acc) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client_acc) > 0 )
	{
		$client_detail_acc = mysql_fetch_assoc($rs_client_acc);
		//pr($client_detail_acc);
		
		
			
	}
	
	
	
}else{
	
	header("location:client.php");	
	die;
}




$error = array();
if(isset($_POST["submit"]))
{
	
	$target_number = $_POST["target_number"];
	
	if($_POST["target_number"]=="")
	{
		//$error["target_number"] = "Please enter phone number !";
	}else{
		
		$sql_check = "select * from client where phone_number = '$target_number' ";	
		
		$rs_target_number = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_target_number) > 0 )
		{
			$client_detail_no = mysql_fetch_assoc($rs_target_number);
			
			if($client_detail_no["id"]==$client_detail["id"])
			{
				
			}else{
				
				$error["target_number"] = "Already exits phone number !";	
				
			}
			
			
		}
		
		
	}
	
	if(empty($error))
	{
			// add in db and send mail with link to admin		
			$target_name = $_POST["client_name"];
			$updated_date_time = date("Y-m-d H:i:s");
			// we need to update detail		
				$sql_update = "update client set
							
							
							phone_number = '$target_number' ,
							
							updated_date_time = '$updated_date_time' 
							where 
							
								client_id = '$client_id'
								and id = '$id' 
							
							
							";
			mysql_query($sql_update) or die ( mysql_error() );	
			
			
			$cc_id = $id;
			$account_id =  $_POST['accountSelector'];
			$profile_id = $_POST['webproperty-dd'];
			
			$sql_update = "update client set
							account_id = '$account_id' ,
							profile_id = '$profile_id' ,
							updated_date_time = '$updated_date_time' 
							where 
								client_id = '$client_id'
								and
								id = '$cc_id'
								
							
							";
			mysql_query($sql_update) or die ( mysql_error() );	
			
			
			
			
			$sql_update = "update call_log set
						client_id = '$client_id' 
						where target_number = '$target_number'
						";
		    mysql_query($sql_update) or die ( mysql_error() );	
			
			
			
	$id = $_GET["id"];
	
	$sql_client = "select * from client where client_id = '$client_id' and phone_number = '$phone_number'  ";
	
	
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	if(mysql_num_rows($rs_client) == 1)
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
	}		
	
			$msg = "Phone number has been updated";
			
	}
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Client</title>
</head>

<body bgcolor="#999999">
<?php include("logout_link.php");?>

<a href="client.php">Back</a>


<form method="post">
	<p><strong>Edit More Phone Number</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table >
        
        
        <tr>
        	<td valign="top">Phone Number</td>
            <td><input type="text" name="target_number" id="target_number" value="<?php if($_POST["target_number"]){ echo $_POST["target_number"];}else{  echo $client_detail["phone_number"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["target_number"])){ echo $error["target_number"]; }?></span>
            </td>        
        </tr>
        
        <?php
		
		if($client_detail_acc['account_id']!="")
		{
		?>
        
         <tr>
        	<td valign="top" class="tbl_label">Account</td>
            <td>
            <select name="accountSelector">
            
     <?php
	$sql_check_account = 
						"
						SELECT * 
						FROM  `ga_account` order by account_name
						";
										
	$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_account)>0)
	{
	 while($ga_account_detail = mysql_fetch_assoc($rs_account))
	 {
		 $selected_acc = '';
		 
		 
		 
		 
		 if($client_detail_acc['account_id']==$ga_account_detail['account_id'])
		{
			$_POST['accountSelector'] = $ga_account_detail["account_id"];
	?>
		<option selected="selected"  <?php echo $selected_acc;?> <?php if($_POST['accountSelector']==$ga_account_detail['account_id']){ echo 'selected';}?> value="<?php echo $ga_account_detail['account_id'];?>"><?php echo $ga_account_detail['account_name'];?></option>
	
    
    <?php
	
		}
	
	}
}
	?>	
    
        
        
    
    </select>
            
            </td>        
        </tr>
        
        
         <tr>
        	<td valign="top" class="tbl_label">Property: </td>
            <td>
            <span id="ajax_result">
    
    <?php 
	
	 if(!isset($_POST['accountSelector']))
	 {
		 ?>
   
     
        <select name="webproperty-dd" >
                
        </select>    
    <?php
	 }
	?>
    
        
    <?php 
	
	 if(isset($_POST['accountSelector']))
	 {
		
		
		 ?>
   
    
	<select name="webproperty-dd" >
    <?php
	$firstAccountId = $_POST['accountSelector'];
	
	 $sql_check_account = 
										"
										SELECT * 
										FROM  `ga_property` 
										where 
										account_id = '$firstAccountId' order by property_name
										
										";
										
	$rs_property = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_property)>0)
	{
	 while($ga_property_detail = mysql_fetch_assoc($rs_property))
	 {
		 
		// pr($ga_property_detail);
		 
		 
		  $selected_profile = '';
		 if($client_detail["profile_id"]==$ga_property_detail['profile_id'])
		 {	
		 	$selected_profile = 'selected="selected"';
			
		 }
		 
		 
	?>
		<option <?php echo $selected_profile;?> <?php if($_POST['webproperty-dd']==$ga_property_detail['profile_id']){ echo 'selected';}?> value="<?php echo $ga_property_detail['profile_id'];?>"><?php echo $ga_property_detail['property_name'];?></option>
	
    
    <?php
	}
}
	?>	
    
</select>
    

<?php
	 }
?>
    
    
    
    </span>
            
            </td>        
        </tr>
        
        
        
        <?php
		}
		?>
        
        
        <tr>
        	
            <td align="center" colspan="2"><input type="submit" name="submit" id="submit" value="Update" /></td>        
        </tr>
    </table>
</form>
</body>
</html>