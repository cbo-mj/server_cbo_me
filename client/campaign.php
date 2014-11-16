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
$client_id = $_GET["id"];
$sql = "SELECT * FROM campaign where client_id = '$client_id'";
//echo $sql;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CBO Call Tracking Client Campaign</title>
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
  jQuery(".add_client_link").colorbox({iframe:true, width: "600px", height: "275px"});
  jQuery(".add_campaign_link").colorbox({iframe:true, width: "600px", height: "270px"});
  jQuery(".campaign_edit_link").colorbox({iframe:true, width: "600px", height: "265px"});
});

	function runTable(){
		var table = $('#call_tracking_record').DataTable({"paginate": true, "sort": false});
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
.content-wrapper {
	min-height: 300px;
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


<div class="row">
    <section>
        <div id="container-body">
            <section class="main-section grid_8">
				<div class="content-head">
					<div class="bg-white-client"><h4>Client List</h4></div>
					<div class="line-area"></div>
					<?php 

					$sql_client = "select * from client where client_id = '$client_id' ";
					$rs_client_detail = mysql_query($sql_client);
					$cc_detail = mysql_fetch_assoc($rs_client_detail);


					$client_name = $cc_detail["client_name"];

					?>
					<div class="clearB"></div>
					<h4 class="client-title">Client Name : <?php echo $client_name;?></h4>
				</div>
                <div class="content-wrapper">
                    <section class="clearfix">
                    <?php
					if(isset($_SESSION["delete_msg"]))
					{
					
					?>
                    <div align="center" style="color:black;"><strong><?php echo $_SESSION["delete_msg"]; unset($_SESSION["delete_msg"]); ?></strong></div>
                    <?php
					}
					?>
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Name</th>                                                                  
                                    <th>Operation</th>
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
                                    <td><?php echo $row["campaign_name"]; ?></td>
                                   
                                    <td>
									
									<a class="campaign_edit_link" href="edit_campaign.php?cpid=<?php  echo $row["campaign_id"]; ?>&id=<?php echo $client_id;?>">Edit</a>
                                    &nbsp;&nbsp;
									<a onClick="return confirm_box();" href="delete_campaign.php?cpid=<?php  echo $row["campaign_id"]; ?>&id=<?php echo $client_id;?>">Delete</a>
                                    
                                  
									
                                                                        
                                    
                                    
                                    </td>                                   
                                </tr>
                           
                           <?php
						   
						   $i++;
						   
					}
				}
						   ?>
                           
                              
                            </tbody>
                        </table>

					<div class="bot-left-side">
					 <a class="default_btn" href="client.php">Back</a>
					 <a class="active_btn add_client_link" href="add_client.php">Add Client</a>
					</div>
					<div class="bot-right-side">
					<a class="active_btn add_campaign_link" href="add_campaign.php?id=<?php echo $_GET["id"];?>">Add Campaign</a>
					<a class="red_btn" href="logout.php">Logout</a>
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