<?php
include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];

$target_number_sql = " and  client_id = '$target_number'  ";
$sql_campaign_id = '';

if($_GET["search"])
{
	
	if(isset($_GET["campaign_id"]) and $_GET["campaign_id"]!="")
	{
		$campaign_id = $_GET["campaign_id"];
		$target_number_sql .= "and campaign_id = '$campaign_id' ";
		$sql_campaign_id = "and campaign_id = '$campaign_id' ";

	}
	
	

	if(isset($_GET["type"]) and $_GET["type"]!="")
	{
		$type = $_GET["type"];
	
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
			
			$from_date = $_GET["from"];
			$to_date = $_GET["to"];
			
			
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
<title>CBO Call Tracking - Audio</title>

<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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

							<div class="item_modals">
							
						   <!--<div align="right">
						 <a href="#"  onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>');">Close</a>
							
						  
							
						   </div>-->
						   
						   
						   
							<h1 class="item-title">Call Detail</h1>
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
												&nbsp;&nbsp;<a class="download_link" href="download.php?path=<?php echo $save_path;?>" target="_blank"> Download</a>
													
											<?php
											}
											?>    
													
											</td>
										</tr>
									</tbody>
								</table>
							
							</div>
							</div>
						<?php
						$i++;
							}
						}
						?>

                        
                    </div>    
                        
                    </section>
                </div>
            </section>
            <div class="clear"></div>
        </div>
    </section>
</div>
</body>
</html>