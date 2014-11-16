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

$client_id = $_GET['client_id'];
 $group_campaign_id = $_GET['id']; 
 
 
 
 	
 $sql_client = "select distinct account_id , profile_id from client where client_id = '$client_id' and  account_id!='' and profile_id!='' ";
$rs_client = mysql_query($sql_client) or die ( mysql_error() );							

if(mysql_num_rows($rs_client) > 0 )
{
	$client_detail = mysql_fetch_assoc($rs_client);
	//pr($client_detail);
	 $account_id = $client_detail['account_id'];
	 
	 $profile_id = $client_detail['profile_id'];
	  
}
	
 
 

$sql_campaign_group = "select * from group_campaign where  	group_campaign_id = '$group_campaign_id' and client_id = '$client_id' ";

$rs_campaign_group = mysql_query($sql_campaign_group) or die ( mysql_error() );

$row_campaign_group = mysql_fetch_assoc($rs_campaign_group);



$error = array();
$msg ="";
if(isset($_POST["submit"]))
{
	
	$name = $_POST["name"];
	
	if($_POST['campaign_type']=="")
	{
		$error["campaign_type"] = "Please select campaign type !";
	}else{
		$campaign_type_val = $_POST['campaign_type'];	
	}
	
	if($name=="")
	{
		$error["name"] = "Please enter campaign group name !";
	}
	
	if(empty($_POST["campaign_id"]))
	{
		$error["campaign_id"] = "Please select campaign !";	
	}
	
	
	
	if(empty($error))
	{
		 $group_campaign_id = $_GET['id']; 
		// add in db and send mail with link to admin
		
		$updated_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			 $sql_insert = "update group_campaign set
							
							campaign_name = '$name',
							campaign_type = '$campaign_type_val',							
							updated_date_time = '$updated_date_time'
							where
							  client_id = '$client_id' 
							and group_campaign_id = '$group_campaign_id'
							
							";
			mysql_query($sql_insert) or die (mysql_error());
			
		
			
			
			 $delete_sql = " delete from group_campaign_link where 
			 
			 				client_id = '$client_id' 
							and group_campaign_id = '$group_campaign_id'
			
			";
			
			mysql_query($delete_sql) or die (mysql_error());
			
			//die;
			  
			
			if(!empty($_POST["campaign_id"]))
			{
				foreach($_POST["campaign_id"] as $camp_id)
				{
					
					$sql_insert = "insert into group_campaign_link set
							client_id = '$client_id',
							group_campaign_id = '$group_campaign_id',
							campaign_id = '$camp_id',
							campaign_type = '$campaign_type_val',					
							created_date_time = '$created_date_time'
							";
					mysql_query($sql_insert) or die (mysql_error());
						
				}
			}
			
			
			$_SESSION['msg']="Campaign Group updated Successfully";
			
			header('location:campaign_group_list.php?client_id='.$client_id);	
			
			$msg = "New campaign group has been added successfully";
			$_POST ='';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Edit Capaign Group</title>
</head>
<body bgcolor="#999999">

<?php include("logout_link.php");?>

<form method="post" >
	<p><strong>Edit Campaign Group</strong></p>
   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table >
    
    
    <?php
		//pr($campaign_type);
		?>
        
    <tr>
        	<td valign="top">Campaign Group TYPE</td>
            <td>
            
            <?php
			
			//pr($campaign_type);
			
			if(!empty($campaign_type))
			{
				foreach($campaign_type as $key=>$value)
				{	
				 echo '<br/>';	
				 $checked = '';
				 if(isset($_POST['campaign_type']) and $_POST['campaign_type']!="")
				 {
					 if(  $_POST['campaign_type']== $key)
					 {
						  $checked = 'checked="checked"';
					 }
					 
				 }else{
					 
					 
					 if(  $row_campaign_group['campaign_type']== $key)
					 {
						  $checked = 'checked="checked"';
					 }
					 
					 
				 }
			?>
            
            <input <?php echo $checked;?>  type="radio" name="campaign_type"   value="<?php echo $key;  ?>" />
            <?php
			 echo $value;
			
			
			?>
           
           <?php
				}
			}
		   ?> 
            
            <br/>
            <span style="color:blue;"><?php if(isset($error["campaign_type"])){ echo $error["campaign_type"];}?></span>
            </td>        
        </tr>
      
       <tr>
        	<td valign="top">Campaign Group Name</td>
            <td><input type="text" name="name" id="name" value="<?php if($_POST["name"]){ echo $_POST["name"];}else{echo $row_campaign_group['campaign_name'];} ?>" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["name"])){ echo $error["name"];}?></span>
            </td>        
        </tr>
        
        
        <?php
		
		


		
		
	/*	
		$sql_campaign = "
SELECT `campaign_id`,`campaign_name` FROM aw_campaign_details   ";*/


  $sql_campaign = "
SELECT `campaign_id`,`campaign_name` FROM aw_campaign_details WHERE `campaign_id` IN 
(SELECT DISTINCT `adwordsCampaignID` FROM `ga_adword_campaign_data_30_days` WHERE `account_id`='$account_id' AND `profile_id`='$profile_id') ";

		
		?>
        
         <tr>
        	<td valign="top">Campaign</td>
            <td>
            
            
            <select name="campaign_id[]" multiple="multiple"  style="height:200px;" >
     
    <?php
	
										
	$rs_campaign = mysql_query($sql_campaign) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_campaign)>0)
	{
	 while($ga_campaign_detail = mysql_fetch_assoc($rs_campaign))
	 {
		 
		// pr($ga_property_detail);
		
		$selected = '';
		if(isset($_POST["campaign_id"]))
		{
				foreach($_POST["campaign_id"] as $camp_id)
				{
					if($ga_campaign_detail['campaign_id']==$camp_id)
					{
						$selected = 'selected="selected"';					
					}
				}
		}else{
				
		$selected = '';
		
		 $sql_campaign_group_link = "select * from  group_campaign_link where  	group_campaign_id = '$group_campaign_id' and client_id = '$client_id' ";

$rs_campaign_group_link = mysql_query($sql_campaign_group_link) or die ( mysql_error() );

		while( $row_campaign_group_link = mysql_fetch_assoc( $rs_campaign_group_link ) )	
		{
			if( $ga_campaign_detail['campaign_id'] == $row_campaign_group_link['campaign_id'] )
			{
				 echo $selected = 'selected="selected"';	
				
			}	
		}
					
	  }
		 
	?>
		<option <?php echo $selected;?>  value="<?php echo $ga_campaign_detail['campaign_id'];?>"><?php echo $ga_campaign_detail['campaign_name'];?></option>
	
    
    <?php
	}
}
	?>	
    
</select> 
            
            <br/>
            <span style="color:blue;"><?php if(isset($error["campaign_id"])){ echo $error["campaign_id"];}?></span>
            </td>        
        </tr>
        
      
        
        
        
        
        <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Update Capaign Group" /></td>        
        </tr>
    </table>
</form>
</body>
</html>