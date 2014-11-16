<?php
include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];

$target_number_sql = " and  client_id = '$target_number'  ";
$sql_campaign_id = '';

if($_POST["search"])
{
	
	if(isset($_POST["campaign_id"]) and $_POST["campaign_id"]!="")
	{
		$campaign_id = $_POST["campaign_id"];
		$target_number_sql .= "and campaign_id = '$campaign_id' ";
		$sql_campaign_id = "and campaign_id = '$campaign_id' ";

	}
	
	

	if(isset($_POST["type"]) and $_POST["type"]!="")
	{
		$type = $_POST["type"];
	
		// today day
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$where = "where date(date) = '$today_date' ";
			$sql = "SELECT * FROM call_log  $where $target_number_sql  order by date desc ";
			
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = "where date(date) = '$yesterday_date' ";
			$sql = "SELECT * FROM call_log  $where $target_number_sql order by date desc ";
			
		}else if($type=="last_week")
		{
			
			$sql = " SELECT *   FROM call_log 
					 WHERE date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
					 AND date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY		
					 $target_number_sql			
					 order by date  desc";	
			
		}else if($type=="last_month")
		{		 
			 $sql = "		 
					SELECT *  FROM call_log
					WHERE YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
					$target_number_sql
					order by date  desc		 
					 ";
			
			
		}else if($type=="last_3_month")
		{
			
			 $sql = "		 
					SELECT *
					FROM call_log
					WHERE MONTH( date ) >= MONTH( CURDATE( ) ) -3
					$target_number_sql
					ORDER BY date DESC		 
					 ";
					 
			
		}else if($type=="last_6_month")
		{
			
			 $sql = "
					SELECT *
					FROM call_log
					WHERE MONTH( date ) >= MONTH( CURDATE( ) ) -6
					$target_number_sql
					ORDER BY date DESC					
					 ";
			
			
			
			
		}else if($type=="last_year")
		{
			$sql = "	
				select * FROM `call_log`
				where 
				date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)	
				$target_number_sql		
				order by date  desc
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
				order by date  desc
				";
				
				
				/*$sql = "	select * FROM `call_log`
							where 
							date >= '$from_date' AND date <= '$to_date'  
							order by date  desc
						";*/
						
						
				
		}
		
		
	
	}else
		{
			$sql = "SELECT * FROM call_log where  client_id = '$target_number'   $sql_campaign_id order by date desc ";
		}

}else{
	
	$sql = "SELECT * FROM call_log where   client_id = '$target_number'  order by date desc ";
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
<link type="text/css" rel="stylesheet" href="StyleSheets/doughnut.css" />


<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<script type="text/javascript">var jslang='EN';</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script src="amcharts/pie.js" type="text/javascript"></script>

<link href="StyleSheets/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<script src="Scripts/jquery.dataTables.js"></script>


<script type="text/javascript">

jQuery(document).ready( function () {

	var total_count = 0;
	var ans_count = 0;
	var miss_count = 0;
	var length = jQuery("#call_tracking_record tbody .call_data").length
	jQuery("#call_tracking_record tbody .call_data").each(function(index){
		if(jQuery(this).text() == "Answered"){
			total_count += 1;
			ans_count += 1;
		}
		if(jQuery(this).text() == "Abandoned"){
			total_count += 1;
			miss_count += 1;
		}
		if(index == (length -1 )){
			runTable();
			runCharts(total_count, ans_count, miss_count);
		}
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
			
			var tbl_title = '<h4 class="head_title">Detailed Call Log</h4>';
			jQuery( tbl_title ).insertAfter( jQuery( ".dataTables_filter" ) );
		});
	}
		
		

		jQuery("#dummy_rec_length").change(function(){
			jQuery("#call_tracking_record_length select").val(jQuery(this).val());
			jQuery("#call_tracking_record_length select").trigger('change');
		});
		
		function runCharts(total, ans, miss){
			AmCharts.makeChart("total_calls",
				{
					"type": "pie",
					"pathToImages": "amcharts/images/",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"innerRadius": "80%",
					"colors": [
						"#3184e4",
						"#FFffff",
						"#FF9E01",
						"#FCD202",
						"#F8FF01",
						"#B0DE09",
						"#04D215",
						"#0D8ECF",
						"#0D52D1",
						"#2A0CD0",
						"#8A0CCF",
						"#CD0D74",
						"#754DEB",
						"#DDDDDD",
						"#999999",
						"#333333",
						"#000000",
						"#57032A",
						"#CA9726",
						"#990000",
						"#4B0C25"
					],
					"titleField": "category",
					"valueField": "column-1",
					"allLabels": [],
					"balloon": {},
					"legend": {
						"align": "center",
						"markerType": "square"
					},
					"titles": [],
					"dataProvider": [
						{
							"category": "Total Calls",
							"column-1": total
						}
					]
				}
			);
		}
		

  
	jQuery("#show-filter-form").click(function(){
		if(jQuery(".filter-form").hasClass("item-hide")){
			jQuery(".filter-form").removeClass("item-hide").addClass("item-show");
		}
		else {
			jQuery(".filter-form").removeClass("item-show").addClass("item-hide");
		}
	});
	
	jQuery("#cmd_default").click(function(){
		jQuery(".filter-form").removeClass("item-show").addClass("item-hide");
		return false;
	});
	
	
});


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
<div id="wrapper">

    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                    
                    
                    <div class="container">
<div class="filter-box">        
	<div class="filter-form-wrap">		
		<div class="filter-text">
			<div class="bg-white">
				<a href="javascript:void(0)" id="show-filter-form">Filter <span class="icon-arrow"></span></a>
				<div class="filter-desc">View: <span>All</span></div>
			</div>
			<div class="line"></div>
		</div>
		<div id="filter-form" class="filter-form item-hide">
		<form method="post">
		<div>
		<div class="frm_cont_top">
		<label>Show: </label><br />
		 <?php
											$sql_camp = "SELECT * FROM campaign where client_id = '$target_number' ";
											
											$rs_call_camp = mysql_query($sql_camp) or die ( mysql_error() );
								
											 ?>
											<select name="campaign_id">
												<option value="">Select Campaign</option>
											  <?php
												if(mysql_num_rows($rs_call_camp)>0)
												{
												$i=1;
												while($row_camp = mysql_fetch_assoc($rs_call_camp))
												{
													$selected = '';
													
													if($selected=="")
													{
														if($row_camp["campaign_id"]==$row_client["campaign_id"]){
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

			<br />
		   <select name="type" onChange="return check_date_range(this.value);" >
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
			&nbsp;
		</div>
		<div class="frm_cont_range" <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){  }else{ ?> style="display:none" <?php } ?> id="date_range">    
		<div class="from-wrap">
		<label class="from-range">From: </label><br />
		<input type="text" id="from" name="from" value="<?php if(isset($_POST["from"])){ echo $_POST["from"];   }?>" />
		</div>
		<div class="clearB"></div>
		<div class="to-wrap">
		<label class="to-range">To: </label><br />
		<input type="text" id="to" name="to" value="<?php if(isset($_POST["to"])){ echo $_POST["to"];   }?>" />
		</div>
		</div>
		<div class="frm_buttons">
			<input type="submit" value="Apply Filters" name="search"  id="cmd_filter">
			<input type="submit" id="cmd_default" value="Cancel">
		</div>
		</div>
		</form>
		</div>
	</div>		
</div>

<div class="clearB"></div>
<div class="chart-box">
	<div class="doughnut_charts">
		<div class="total_calls_wrap">
			<div id="total_calls" style="width: 250px; height: 250px; background-color: #FFFFFF;" ></div>
		</div>
		<div class="miss_call_wrap">
			<div id="miss_call" style="width: 250px; height: 250px;"></div>
		</div>
		<div class="answer_call_wrap">
			<div id="answer_call" style="width: 250px; height: 250px;"></div>
		</div>
		<div class="average_call_wrap">
			<div id="average_call" style="width: 250px; height: 250px;"></div>
		</div>
	</div>
</div>
<div class="clearB"></div>
					
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                   
                                    <th>Date</th>
                                    <th>Caller</th>
                                    <th>Duration</th>
                                   <!-- <th>Answert Point</th>-->
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                   <!-- <th>Recording</th>-->
                                    <th>&nbsp;</th>
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
                                    
                                    <td>
                                    
                                    <?php  echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date)); ?>
                                    
                                    <!--5th May '14 - 11:58:01-->
                                    
                                    </td>
                                    <td><?php echo $row["caller_number"]; ?></td>
                                    <td><?php 
									echo $row["duration"];
									
									 ?></td>
                                   
                                    <td>
									
									<?php echo $row["location"]; ?> ,
                                    <?php echo $row["state"]; ?> ,
                                    <?php echo $row["country"]; ?>
                                    
                                    
                                    </td>
                                    <td class="call_data"><?php echo $row["status_name"]; ?></td>
                                   <!-- <td align="center"><img src="Images/call-tracking-icon-2.png" /></td>-->
                                    <td>
                                    
                                    <?php
									
									$caller_id = $row["caller_id"];
                                    $save_path = "audio/$caller_id.wav";
                                    
                                    if(file_exists($save_path))
                                    {
                                    ?>
                                    
                                   	<a href="download.php?path=<?php echo $save_path;?>" target="_blank"> <img src="Images/call-tracking-icon-3.png" /></a>
                                    
                                    
                                    <?php
                                    
                                    }
                                    ?>
                                    
                                    
                                    </td>
                                    
                                    <td>
                                    
                                    <a href="#" onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>');" data-reveal-id="modal_<?php echo $i;?>"><img src="Images/call-tracking-icon-1.png" /></a>
                                    
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


$rs_call_log = mysql_query($sql) or die ( mysql_error() );


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
}
?>


<!--<link rel="stylesheet" href="jquery_developement_lib/themes/base/jquery.ui.all.css">-->

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
<!--<link rel="stylesheet" href="jquery_developement_lib/demos.css">-->


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


</script>


<!--<div id="model_1" title="Model 1" style="display:none;">
	<p>This is model 1.</p>
</div>
<button  onClick="return dialog_open('model_1');">Model 1</button>

<div id="model_2" title="Model 2" style="display:none;">
	<p>This is model 2.</p>
</div>
<button  onClick="return dialog_open('model_2');">Model 2</button>-->

</body>
</html>