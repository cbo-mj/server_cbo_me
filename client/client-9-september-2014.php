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

$sql = " SELECT * FROM client where client_name !='' ";
//echo $sql;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CBO Call Tracking Client</title>
<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<link rel="stylesheet" href="colorbox/colorbox.css" />
<script type="text/javascript">var jslang='EN';</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="colorbox/jquery.colorbox.js"></script>
<link href="StyleSheets/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="Scripts/jquery.dataTables.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready( function () {
  runTable();
  jQuery(".iframe-add-client").colorbox({iframe:true, width: "495px", height: "310px"});
  jQuery(".add_client_link").colorbox({iframe:true, width: "520px", height: "310px"});
  jQuery(".client_edit_link").colorbox({iframe:true, width: "495px", height: "370px"});

});

	function runTable(){
		var table = $('#call_tracking_record').DataTable({"paginate": true, "sort": false, "aLengthMenu": [[25, 50, 75, "All"], [25, 50, 75, -1]], "iDisplayLength": 25} );
		jQuery("#call_tracking_record").promise().done(function(){
			var dummy_cont = "";
			jQuery("#call_tracking_record_length select option").each(function(){
				dummy_cont += '<option value="' + jQuery(this).attr("value") + '">' + jQuery(this).attr("value") + '</option>';
			});
			var dummy_complete = '<div class="tbl_foot_rec_length"><label>Page size:</label> <select id="dummy_rec_length">' + dummy_cont + '</select></div>';
			jQuery( dummy_complete ).insertAfter( jQuery( "#call_tracking_record_paginate" ) );
			jQuery("#call_tracking_record").nextAll().wrapAll( "<div class='foot_wrap' />");
		});
	}
 </script>
 <style type="text/css">
 	/*#cboxContent{ height: 310px !important; width: 485px !important;}*/
 </style>
<script type="text/javascript">
	
function change_campaign(campaign_id,client_id,id,phone_number)
{
	// $campaign_id = $_GET["campaign_id"];

	
	var url = "change_campaign.php?campaign_id="+campaign_id+"&client_id="+client_id+"&id="+id+"&phone_number="+phone_number;
	var request = jQuery.ajax({
						url: url,
						type: "POST",
						
					});					
		request.done(function(msg) {	
		
		console.log(msg);
		
		
			if(msg==1)
			{
				alert("Successfully updated campaign ");
				location.reload(true);
				//return false;	
			}
		
		//console.log(msg);		
		
		});		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			return false;
		});
	return false;
	
}


</script>


<style>

body {
    padding: 0px !important;
}
.dataTables_wrapper .dataTables_filter {
    display: none;
}
.cboxIframe {
    position: absolute;
}
#wrapper ul {
    width: 100% !important;
    background: white;
    height: 40px;
    border-bottom: 1px solid #e8e7e4;
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
}
#wrapper ul li {
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
}
#wrapper ul li a {
    display: block;
    height: 40px;
    line-height: 40px;
    padding: 0 12px;
    font-size: 11px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}
#wrapper ul li.active a, #wrapper ul li.more-active a.morelink {
    background: #2996e3;
    background: -moz-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2996E3), color-stop(100%, #387ED7));
    background: -webkit-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -o-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -ms-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: linear-gradient(top, #2996E3 0%, #387ED7 100%);
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2996e3', endColorstr='#387ed7', GradientType=0 );
    position: relative;
    color: white;
    text-shadow: 0 1px 1px #004B7C !important;
}
tr th {
    background: #dbdbda;
    padding: 8px 4px;
    text-align: left;
}
tr td {
    padding: 8px 4px;
}
tr.odd {
    background: #f2f2f2;
}
</style>
<style>
		
body {
	font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
	margin: 0;
	padding: 0;
	color: #333;
	background-color: #fff;
}

div.container {
	min-width: 980px;
	margin: 0 auto;
}
</style>  


</head>
<body class="hybrid">



<div id="wrapper">


<div> <!-- class="row" -->
    <section>
        <div id="container-body">

            <section class="main-section grid_8">
				<div class="content-head">
					<?php include("logout_link.php");?>
					<div class="bg-white-client"><h4>Client List</h4></div>
					<div class="line-area"></div>
				</div>
                <div class="content-wrapper">
                    <section class="clearfix">
                    <div class="container-client">
                    <?php
					if(isset($_SESSION["delete_msg"]))
					{
					?>
                    <div align="center" style="color:black;"><strong><?php echo $_SESSION["delete_msg"]; unset($_SESSION["delete_msg"]); ?></strong></div>
                    <?php
					}
					?>
                    
                        <table id="call_tracking_record" class="display"  width="100%">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Avanser Name </th>
                                    <th>Client ID </th>
                                    <th width="105">Advertised Number </th>
                                    <th>Destination Number</th>
                                    <!--<th width="75">&nbsp;</th>-->  
                                    <th width="130">Campaign</th>                                
                                    <th width="250">Operation</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
						$rs_call_log = mysql_query($sql) or die ( mysql_error() );
							if(mysql_num_rows($rs_call_log)>0)
							{
							$i=1;
							while($row = mysql_fetch_assoc($rs_call_log))
							{
							
						
							?>
                               
                                <tr class="odd">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row["client_name"]; ?></td>
                                    
                                    <td><?php echo $row["client_id"]; ?></td>
                                    <td><?php echo $row["phone_number"]; ?></td>
                                    <td><?php echo $row["destination_number"]; ?></td>
                                    <!--<td>
										<?php //if( $row["client_name"]!=""){ ?>
										<a class="add_client_link" href="add_client_phoneno.php?id=<?php //echo $row["client_id"]; ?>">Add Number</a>
										<?php //}
										?>									
                                    </td>--> 
                                    <td>
                                    
                                    <?php
									$client_id = $row["client_id"];
									$sql_camp = "SELECT * FROM campaign where client_id = '$client_id' ";
									
									$rs_camp = mysql_query($sql_camp) or die ( mysql_error() );
						
									 ?>
                                    <select name=""  id="" onChange="return change_campaign(this.value,'<?php echo $row["client_id"];?>','<?php echo $row["id"];?>','<?php echo $row["phone_number"];?>')">
                                    	<option value="">Select Campaign</option>
                                      <?php
										if(mysql_num_rows($rs_camp)>0)
										{
										
										while($row_camp = mysql_fetch_assoc($rs_camp))
										{
											$selected = '';
											
											if($selected=="")
											{
												if($row["campaign_id"]==$row_camp["campaign_id"]){
													$selected = 1;
												}
													
											}
								
									  	?>
                                       		<option <?php if($selected==1){ ?> selected <?php }?> value="<?php echo $row_camp["campaign_id"];?>"><?php echo $row_camp["campaign_name"];?></option>
                                        
                                        <?php
										}
								}
										?>
                                        
                                    
                                    </select>
                                    </td>                        
                                    <td>
									<a class="client_edit_link" href="edit_client.php?id=<?php echo $row["client_id"]; ?>&phone_number=<?php echo $row["phone_number"]; ?>&cc_id=<?php echo $row["id"]; ?>">Edit</a> &nbsp;&nbsp; &nbsp;&nbsp;
									<a onClick="return confirm_box();" href="delete_client.php?id=<?php echo $row["client_id"]; ?>&phone_number=<?php echo $row["phone_number"]; ?>">Delete</a>
                                    &nbsp;&nbsp;
                                    <?php if( $row["client_name"]!=""){ ?>
										<a class="add_client_link" href="add_client_phoneno.php?id=<?php echo $row["client_id"]; ?>">Add Number</a> &nbsp;&nbsp;
										<?php }
										?>	
                                    <a href="campaign.php?id=<?php echo $row["client_id"]; ?>"> Campaign</a>
                                    </td>                                   
                                </tr>
                                
                                
                                  <?php
								$client_id = $row["client_id"];									
								$sql_more = " SELECT * FROM client where client_id = '$client_id' and client_name ='' ";
								
								$rs_call_log_more = mysql_query($sql_more) or die ( mysql_error() );
								if(mysql_num_rows($rs_call_log)>0)
								{
									$j=$i+1;
									
									while($row_more = mysql_fetch_assoc($rs_call_log_more))
									{
									
									?>
                                  <tr class="odd">
                                    <td><?php echo $j; $i=$j;?></td>
                                    <td><?php echo $row["client_name"]; ?></td>
                                    
                                     <td><?php echo $row_more["client_id"]; ?></td>
                                    
                                    
                                    <td><?php echo $row_more["phone_number"]; ?></td>
                                   <td><?php echo $row_more["destination_number"]; ?></td>
                                     
                                      <!--<td> 
                                    <?php //if( $row["client_name"]!=""){ ?>
                                  <!--  <a href="add_client_phoneno.php?id=<?php //echo $row_more["client_id"]; ?>"> 
                                    
                                    <img src="images/add_more.png">
                                    </a>-->
                                    <?php //} ?>
                                    
                                    <!--</td>-->
                                    
                                    
                                     <td>
                                    
                                    <?php
									$client_id = $row_more["client_id"];
									$sql_camp = "SELECT * FROM campaign where client_id = '$client_id' ";
									
									$rs_camp = mysql_query($sql_camp) or die ( mysql_error() );
						
									 ?>
                                   
                                   <select name=""  id="" onChange="return change_campaign(this.value,'<?php echo $row_more["client_id"];?>','<?php echo $row_more["id"];?>','<?php echo $row_more["phone_number"];?>')">
                                   
                                   
                                   
                                    	<option value="">Select Campaign</option>
                                      <?php
										if(mysql_num_rows($rs_camp)>0)
										{
										
										while($row_camp = mysql_fetch_assoc($rs_camp))
										{
											$selected = '';
											
											if($selected=="")
											{
												if($row_more["campaign_id"]==$row_camp["campaign_id"]){
													$selected = 1;
												}
													
											}
								
									  	?>
                                       		<option <?php if($selected==1){ ?> selected <?php }?> value="<?php echo $row_camp["campaign_id"];?>"><?php echo $row_camp["campaign_name"];?></option>
                                        
                                        <?php
										}
								}
										?>
                                        
                                    
                                    </select>
                                    
                                    
                                    </td>
                                    
                                    
                                    
                                    
                                    <td>
                                    
                                     
                                    
                                   
									
									<a href="edit_client_phoneno.php?id=<?php echo $row_more["id"]; ?>&client_id=<?php echo $row_more["client_id"]; ?>&phone_number=<?php echo $row_more["phone_number"]; ?>">Edit</a> &nbsp;&nbsp; &nbsp;&nbsp;
									<a onClick="return confirm_box();" href="delete_client.php?id=<?php echo $row_more["client_id"]; ?>&phone_number=<?php echo $row_more["phone_number"]; ?>">Delete</a>
                                    <?php if( $row["client_name"]!=""){ ?>
                                  <!--  <a href="add_client_phoneno.php?id=<?php echo $row_more["client_id"]; ?>"> 
                                    
                                    <img src="images/add_more.png">
                                    </a>-->
                                    <?php } ?>
                                    
                                    </td>                                   
                                </tr>  
                                    
                                 <?php
								 
									$j++;
									 }
								}
								 ?>   
                                
                            
                           
                           <?php
						   
						   $i++;
						   
					}
				}
						   ?>
                           
                              
                            </tbody>
                        </table>
                        
                    </div>    
                        
                    </section>
                </div>
            </section>
            <div class="clear"></div>
        </div>
    </section>
	
	
	
	
	</div>
</div>

<script type="text/javascript">
function confirm_box()
{
	var answer = confirm ("Are you sure you want to delete?")
	if (!answer)
	{
		return false;
	}
}
</script>
</body>
</html>