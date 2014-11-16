<?php
include("include/connection.php");
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

