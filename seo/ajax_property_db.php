<?php
include("include/connection.php");
?>

  Property
<select name="webproperty-dd" >

    <?php
	$firstAccountId = $_POST['account_id'];
	
	 $sql_check_account = 
										"
										SELECT * 
										FROM  `ga_property` 
										where 
										account_id = '$firstAccountId'
										
										";
										
	$rs_property = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_property)>0)
	{
	 while($ga_property_detail = mysql_fetch_assoc($rs_property))
	 {
	?>
		<option <?php if($_POST['webproperty-dd']==$ga_property_detail['profile_id']){ echo 'selected';}?> value="<?php echo $ga_property_detail['profile_id'];?>"><?php echo $ga_property_detail['property_name'];?></option>
	
    
    <?php
	}
}
	?>	
    
</select>
    
    

