<?php
session_start();
if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}
include("head_include.php");
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

if(isset($_GET["id"]) and $_GET["id"]!="" )
{
	 $id = $_GET["id"];
	 $phone_number_for_where = $_GET["phone_number"];
	 $cc_id = $_GET["cc_id"];
	 $sql_client = "select * from client where client_id = '$id' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
			
	}else{
		header("location:client.php");	
		die;
	}
	
}else{
	
	header("location:client.php");	
	die;
}




$error = array();
if(isset($_POST["submit"]))
{
	if($_POST["client_name"]=="")
	{
		$error["client_name"] = "Please enter client name !";
	}
	
	$target_number = $_POST["target_number"];
	
	if($_POST["target_number"]=="")
	{
		//$error["target_number"] = "Please enter phone number !";
	}else{
		
		$sql_check = "select * from client where phone_number = '$target_number' and  client_id != '$id' ";	
		
		$rs_target_number = mysql_query($sql_check);
		
		if(mysql_num_rows($rs_target_number) > 0 )
		{
			$error["target_number"] = "Already exits phone number !";	
		}
		
		
	}
	
	if(empty($error))
	{
			
			$account_id =  $_POST['accountSelector'];
			$profile_id = $_POST['webproperty-dd'];
			
			$group =  $_POST['group'];
			$domain = $_POST['domain'];
			
			// add in db and send mail with link to admin		
			$target_name = $_POST["client_name"];
			$updated_date_time = date("Y-m-d H:i:s");
			// we need to update detail		
				$sql_update = "update client set
							
							client_name = '$target_name' ,
							phone_number = '$target_number' ,
							
							
							updated_date_time = '$updated_date_time' 
							where 
							
								client_id = '$id' and id = $cc_id
								
							
							
							";
			mysql_query($sql_update) or die ( mysql_error() );	
			
			
			$sql_update = "update client set
							account_id = '$account_id' ,
							profile_id = '$profile_id' ,
							
							al_group_id = '$group' ,
							al_domain_id = '$domain' ,
							
							updated_date_time = '$updated_date_time' 
							where 
								client_id = '$id'
								
								
							
							";
			mysql_query($sql_update) or die ( mysql_error() );	
			
			/*and
								id = $cc_id*/
			
			$sql_update = "update call_log set
						client_id = '$id'
						where target_number = '$target_number'
						";
		    mysql_query($sql_update) or die ( mysql_error() );	
			
			
			
	$id = $_GET["id"];
	
	$sql_client = "select * from client where client_id = '$id' ";
	
	
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	if(mysql_num_rows($rs_client) == 1)
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
	}		
	
			$msg = "Client name has been updated";
			
			
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
<title>Edit Client</title>
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
   <h1 class="item-title">Edit Client</h1>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table class="pop-up-table">
        <tr>
        	<td valign="top" class="tbl_label">Name</td>
            <td><input type="text" name="client_name" id="client_name" value="<?php echo $client_detail["client_name"];?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["client_name"])){ echo $error["client_name"]; }?></span>
            </td>        
        </tr>
        <tr>
        	<td valign="top" class="tbl_label">Phone Number</td>
            <td><input type="text" name="target_number" id="target_number" value="<?php if($_POST["target_number"]){ echo $_POST["target_number"];}else{  echo $client_detail["phone_number"];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["target_number"])){ echo $error["target_number"]; }?></span>
            </td>        
        </tr>
        
         <tr>
        	<td valign="top" class="tbl_label">Account</td>
            <td>
            <select name="accountSelector" onChange="return submit_form(this.value);"  style="border:1px solid #979393;">
        <option value="">Select an account</option>        
     <?php
	$sql_check_account = 
						"
						SELECT * 
						FROM  `ga_account` where account_id not in ( select distinct account_id from client 
						      where client_id <> $id) order by account_name
						";
										
	$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_account)>0)
	{
	 while($ga_account_detail = mysql_fetch_assoc($rs_account))
	 {
		 $selected_acc = '';
		 if($client_detail["account_id"]==$ga_account_detail['account_id'])
		 {	
		 	$selected_acc = 'selected="selected"';
			$_POST['accountSelector'] = $client_detail["account_id"];
		 }
		 
		 
	?>
		<option  <?php echo $selected_acc;?> <?php if($_POST['accountSelector']==$ga_account_detail['account_id']){ echo 'selected';}?> value="<?php echo $ga_account_detail['account_id'];?>"><?php echo $ga_account_detail['account_name'];?></option>
	
    
    <?php
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
   
     
        <select name="webproperty-dd" style="border:1px solid #979393;">
                
        </select>    
    <?php
	 }
	?>
    
        
    <?php 
	
	 if(isset($_POST['accountSelector']))
	 {
		
		
		 ?>
   
    
	<select name="webproperty-dd" style="border:1px solid #979393;">
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
        
        
          <tr>
        	<td valign="top" class="tbl_label">Group</td>
            <td>
            
            <?php
			
			 $sql_check_account = 
						"
						SELECT * 
						FROM  `authority_lab_group` where group_id not in ( select distinct al_group_id from client 
						      where client_id <> $id) order by name
						";;
			?>
            
            <select name="group" onChange="return submit_form_group(this.value);"  style="border:1px solid #979393;">
        <option value="">Select an group</option>        
     <?php
	
										
	$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_account)>0)
	{
	 while($al_group_detail = mysql_fetch_assoc($rs_account))
	 {
		 $selected_acc = '';
		 if($client_detail["al_group_id"]==$al_group_detail['group_id'])
		 {	
		 	$selected_acc = 'selected="selected"';
			$_POST['group'] = $client_detail["al_group_id"];
		 }
		 
		 
	?>
		<option  <?php echo $selected_acc;?> <?php if($_POST['group']==$al_group_detail['group_id']){ echo 'selected';}?> value="<?php echo $al_group_detail['group_id'];?>"><?php echo $al_group_detail['name'];?></option>
	
    
    <?php
	}
}
	?>	
    </select>
            
            </td>        
        </tr>
        
         <tr>
        	<td valign="top" class="tbl_label">Domain: </td>
            <td>
            <span id="ajax_result_domain">
    
    <?php 
	
	 if(!isset($_POST['group']))
	 {
		 ?>
   
     
        <select name="domain" style="border:1px solid #979393;">
                
        </select>    
    <?php
	 }
	?>
    
        
    <?php 
	
	 if(isset($_POST['group']))
	 {
		
		$group_id = $_POST['group'];
	
	 $sql_check_account = 
										"
										SELECT * 
										FROM  `authority_lab_domain` 
										where 
										group_id = '$group_id'
										
										group by url
										order by url   
										
										";
										
											
	$rs_property = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	
	
	
		 ?>
   
    
	<select name="domain" style="border:1px solid #979393;">
    <?php
	
	
	
	if(mysql_num_rows($rs_property)>0)
	{
	 while($ga_domain_detail = mysql_fetch_assoc($rs_property))
	 {
		 
		// pr($ga_property_detail);
		 
		 
		  $selected_profile = '';
		 if($client_detail["al_domain_id"]==$ga_domain_detail['domain_id'])
		 {	
		 	$selected_profile = 'selected="selected"';
			
		 }
		 
		 
	?>
		<option <?php echo $selected_profile;?> <?php if($_POST['domain']==$ga_domain_detail['domain_id']){ echo 'selected';}?> value="<?php echo $ga_domain_detail['domain_id'];?>"><?php echo $ga_domain_detail['url'];?></option>
	
    
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
        
        
        
        
       
    </table>
	</div>
    
    <script type="text/javascript">
   
function submit_form(account_id)
{
	var str = "";	
	str = "account_id="+account_id;
	var url = "ajax_property_db.php";	
	$("#img").show(); 
	var request = $.ajax({
						url: url,
						type: "POST",
						data: str
					});
					
		request.done(function(msg) {
			
			
			//alert(msg);
			$("#ajax_result").html(msg);
			$("#img").hide();
			
		});
		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			return false;
		});
	
	return false;
	
}


function submit_form_group(group_id)
{
	var str = "";	
	str = "group="+group_id;
	var url = "ajax_domain_db.php";	
	$("#img").show(); 
	var request = $.ajax({
						url: url,
						type: "POST",
						data: str
					});
					
		request.done(function(msg) {
			
			
			//alert(msg);
			$("#ajax_result_domain").html(msg);
			$("#img").hide();
			
		});
		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			return false;
		});
	
	return false;
	
}

   
   
   </script>
 
	<div class="frm_buttons"><input type="submit" name="submit" class="active_btn" id="submit" value="Update" /></div>
</form>
</body>
</html>