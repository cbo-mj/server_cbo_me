<?php
include("include/connection.php");
include("include/common_function.php");


$target_number = $_GET["id"];




$target_number_sql = " and target_number = '$target_number'   ";

$target_number_sql = '';

if($_POST["search"])
{

	if(isset($_POST["type"]) and $_POST["type"]!="")
	{
		$type = $_POST["type"];
	
		// today day
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$where = "where date(date) = '$today_date' ";
			$sql = "SELECT * FROM call_log  $where $target_number_sql group by caller_number ";
			
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = "where date(date) = '$yesterday_date' ";
			$sql = "SELECT * FROM call_log  $where $target_number_sql group by caller_number ";
			
		}else if($type=="last_week")
		{
			
			$sql = " SELECT *   FROM call_log 
					 WHERE date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
					 AND date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY		
					 $target_number_sql			
					 group by caller_number";	
			
		}else if($type=="last_month")
		{		 
			 $sql = "		 
					SELECT *  FROM call_log
					WHERE YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
					$target_number_sql
					group by caller_number	 
					 ";
			
			
		}else if($type=="last_3_month")
		{
			
			 $sql = "		 
					SELECT *
					FROM call_log
					WHERE MONTH( date ) >= MONTH( CURDATE( ) ) -3
					$target_number_sql
					group by caller_number		 
					 ";
					 
			
		}else if($type=="last_6_month")
		{
			
			 $sql = "
					SELECT *
					FROM call_log
					WHERE MONTH( date ) >= MONTH( CURDATE( ) ) -6
					$target_number_sql
					group by caller_number				
					 ";
			
			
			
			
		}else if($type=="last_year")
		{
			$sql = "	
				select * FROM `call_log`
				where 
				date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)	
				$target_number_sql		
				group by caller_number
				";
				
		}else if($type=="date_range")
		{
			
			$from_date = $_POST["from"];
			$to_date = $_POST["to"];
			
			
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			
			 $sql = "	
				select * FROM `call_log`
				where 
				date between '$from_date' AND '$to_date'
				$target_number_sql		
				group by caller_number
				";
				
				
				/*$sql = "	select * FROM `call_log`
							where 
							date >= '$from_date' AND date <= '$to_date'  
							order by date  desc
						";*/
						
						
				
		}
		
		
	
	}else
		{
			$sql = "SELECT * FROM call_log  group by caller_number  ";
		}

}else{
	
	$sql = "SELECT * FROM call_log  group by caller_number ";
}


//echo $sql;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO Call Tracking</title>

<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />


<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<script type="text/javascript">var jslang='EN';</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


<link href="http://datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>



<script type="text/javascript">







function close_model_old(id,caller_id)
{

	
	var yourAudio = document.getElementById('yourAudio_'+caller_id);
	
	var method =  'pause' ;
	yourAudio[method]();
	


jQuery("#"+id).css({

"opacity":"0",
"visibility": "hidden",
"display": "none"
}

);

}


function change_client(client_id,id)
{
	var url = "change_client.php?client_id="+client_id+"&id="+id;
	
	
	
	var request = jQuery.ajax({
						url: url,
						type: "POST",
						
					});					
		request.done(function(msg) {	
		
		console.log(msg);
		
		
			if(msg==1)
			{
				alert("Successfully updated client ");
					location.reload(true);
			//	return false;	
			}
		
		//console.log(msg);		
		
		});		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
		
			return false;
		});
	return false;
	
	
}

function change_campaign(campaign_id,id)
{
	var url = "change_campaign.php?campaign_id="+campaign_id+"&id="+id;
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


<script type="text/javascript">

$(document).ready( function () {
  var table = $('#call_tracking_record').DataTable(
  
 {
	      "paginate": true,
	      "sort": false
		  
		  
		  
	       }
  
  );
} );


</script>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
-->

<script type="text/javascript">
$(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  { 
    $( "#from" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true ,//this option for allowing user to select from year range	  
	  dateFormat: 'yy-mm-dd' 
	  
    });
	
	
	$( "#to" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
	  dateFormat: 'yy-mm-dd' 
    });
	
	
  }
  

);


function check_date_range(value)
{
	if(value=="date_range")
	{
		$("#date_range").show();
	}else{
		$("#date_range").hide();	
	}
}

</script>

<style>

body {
    padding: 0px !important;
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

<form method="post">


<div align="center" style="margin-top:20px; margin-top:20px; position:relative;">

   <select name="type" style="width:300px;" onChange="return check_date_range(this.value);" >
        <option value="">Please select</option>    
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="today"){echo "selected"; } ?> value="today">Today</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Month</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Month</option>
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
    </select>
    
    
    <span <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){  }else{ ?> style="display:none" <?php } ?> id="date_range">
    
    <br/>
    
   From: <input style="width:200px; " type="text" id="from" name="from" value="<?php if(isset($_POST["from"])){ echo $_POST["from"];   }?>" />
To: <input style="width:200px;   " type="text" id="to" name="to" value="<?php if(isset($_POST["to"])){ echo $_POST["to"];   }?>" />

    
    </span>
    
    <input type="submit" value="Search" name="search" style="width:200px; height:40px; position:absolute;  ">
</div>





</form>




<div id="wrapper">

    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                    
                    
                    <div class="container">
                    
                    
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                   
                                    
                                    <th>Caller</th>
                                    
                                    <th>Client</th>
                                    <th>Campaign</th>
                                  
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
				
				
							$date = $row["date"];
				 			$d = date("d",strtotime($date));
						    $date_prefix = addOrdinalNumberSuffix($d);
						
							?>
                               
                                <tr class="odd">
                                    
                                   
                                    <td><?php echo $row["caller_number"]; ?></td>
                                   
                                   
                                    <td>
									
									
									
									<?php
									$sql_client = "SELECT * FROM client ";
									
									$rs_call_client = mysql_query($sql_client) or die ( mysql_error() );
						
									 ?>
                                    <select name=""  id="" onChange="return change_client(this.value,'<?php echo $row["caller_number"];?>')">
                                    	<option value="">Select Client</option>
                                      <?php
										if(mysql_num_rows($rs_call_client)>0)
										{
										$i=1;
										while($row_client = mysql_fetch_assoc($rs_call_client))
										{
											
											$selected = '';
																					
											
											if($selected=="")
											{
												if($row["client_id"]==$row_client["target_number"]){
													$selected = 1;
												}
													
											}
											
											
											
								
									  	?>
                                       		<option  <?php if($selected==1){ ?> selected <?php }?>  value="<?php echo $row_client["target_number"];?>"><?php echo $row_client["target_name"]; ?></option>
                                        
                                        <?php
										}
								}
										?>
                                        
                                    
                                    </select>
                                     
                                     </td>
                                   
                                    <td>
                                    
                                    <?php
									$client_id = $row["client_id"];
									$sql_camp = "SELECT * FROM campaign where client_id = '$client_id' ";
									
									$rs_camp = mysql_query($sql_camp) or die ( mysql_error() );
						
									 ?>
                                    <select name=""  id="" onChange="return change_campaign(this.value,'<?php echo $row["caller_number"];?>')">
                                    	<option value="">Select Campaign</option>
                                      <?php
										if(mysql_num_rows($rs_camp)>0)
										{
										$i=1;
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
                                   
                                   
                                   
                                   
                                  
                                    
                                </tr>
                           
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




<?php


/*$rs_call_log = mysql_query($sql) or die ( mysql_error() );


if(mysql_num_rows($rs_call_log)>0)
	{
	$i=1;
	while($row = mysql_fetch_assoc($rs_call_log))
	{

		$date = $row["date"];
						$d = date("d",strtotime($date));
						$date_prefix = addOrdinalNumberSuffix($d);
						
						$caller_id = $row["caller_id"];
		
			
	?>
    <div id="modal_<?php echo $i;?>" title="Call Detail" style="display:none;" >
    
   <!--<div align="right">
 <a href="#"  onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>');">Close</a>
    
  
    
   </div>-->
   
   
   
       
       <table width="100%" >
            <tbody>
                <tr>
                    <td align="right"><b>Date and Time</b></td>
                    <td align="left">
                    
                    <!--5th May ‘14 - 11:51:22-->
                    
                    <?php echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date));?>
                    
                    
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Caller:</b></td>
                    <td align="left"><?php echo $row["caller_number"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Advertised Number:</b></td>
                    <td align="left">
					<?php echo $row["target_number"]; ?> -
                    
                     <?php  echo $row["target_name"]; ?>
                                          
                     
                     </td>
                </tr>
                <tr>
                    <td align="right"><b>Location:</b></td>
                    <td align="left">
									<?php echo $row["location"]; ?> ,
                                    <?php echo $row["state"]; ?> ,
                                    <?php echo $row["country"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Status:</b></td>
                    <td align="left"><?php echo $row["status_name"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Duration:</b></td>
                    <td align="left"><?php 
									echo $row["duration"];
									
									 ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Audio/File:</b></td>
                    <td align="left">
                       
                       <?php
					   $save_path = "audio/$caller_id.wav";
	
					if(file_exists($save_path))
					{
					?>
                       
                        <audio controls id="yourAudio_<?php echo $caller_id;?>">                           
                            <source src="<?php echo  $save_path;?>" type="audio/wav">
                            Your browser does not support the audio element. </audio>
                            
                            
                            <div id="div_<?php echo $caller_id;?>" style="display:none"></div>
                            
                            
                    <?php
					}
					?>    
                            
                    </td>
                </tr>
                <tr valign="top">
                    <td align="right"><b>Conversion Info:</b></td>
                    <td align="left"> <b>Medium:</b> <?php echo $row["webUrl"]; ?><br />
                        <b>Source:</b> <?php echo $row["webSource"]; ?><br />
                        <b>Keywords:</b><?php echo $row["webKeyword"]; ?> <br />
                        <b>Campaign:</b><?php echo $row["webCampagin"]; ?> <br />
                        <b>Referrer:</b><?php echo $row["webReferrer"]; ?> <br />
                        <br />
                        <b>Website:</b> <?php echo $row["webUrl"]; ?><br />
                        <b>Landing page:</b> <?php echo $row["webLandning"]; ?><br />
                        <b>Conversion page:</b> <?php echo $row["webConversion"]; ?><br />
                        <b>Medium:</b> <?php echo $row["webMedium"]; ?><br />
                        <br />
                        <b>IP address:</b> <?php echo $row["IP"]; ?>  </td>
                </tr>
            </tbody>
        </table>
    
	</div>

<?php
$i++;
	}
}*/
?>


<script src="jquery_developement_lib/ui/jquery.ui.core.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.widget.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.mouse.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.draggable.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.position.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.resizable.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.button.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.dialog.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.effect.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.effect-blind.js"></script>
<script src="jquery_developement_lib/ui/jquery.ui.effect-explode.js"></script>


<script type="text/javascript">

function close_open_model(id,caller_id)
{


	$("#"+id).dialog({
    
        width:'90%'
});

	
	$( "#"+id ).dialog(					
		{
				
				 close: function(event, ui) {  
				 
				// 
				
				var check = "div_"+caller_id;
				//alert(caller_id);
				
				
				//if(document.getElementById("check") !== null)
				if($('#'+check).length)
				{
				
				
					var yourAudio = document.getElementById('yourAudio_'+caller_id);	
					var method =  'pause' ;
					yourAudio[method]();
					
				}
				 
				 }
		}
		
	
	);



	


}





function dialog_open(dialog_id)
	{
	 var name = "kamal";
		$( "#"+dialog_id ).dialog(					
							{
									
									 close: function(event, ui) {  
									 
									 alert("close button press user"+name);
									 
									 }
							}
							
						
						);
	
	}


</script>



</body>
</html>