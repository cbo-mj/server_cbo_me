<?php
include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];
$target_number_sql = " and  client_id = '$target_number'  ";
$sql_campaign_id = '';

if($_GET["search"]){
	if(isset($_GET["campaign_id"]) and $_GET["campaign_id"]!=""){
		$campaign_id = $_GET["campaign_id"];
		$target_number_sql .= "and campaign_id = '$campaign_id' ";
		$sql_campaign_id = "and campaign_id = '$campaign_id' ";
	}
	if(isset($_GET["type"]) and $_GET["type"]!=""){
		$type = $_GET["type"];
		// today day
		if($type=="today"){
			$today_date = date( "Y-m-d" );
			$where = " date(date) = '$today_date' and";
			$where_a = " a.date_a = '$today_date' " ;
		}else if($type=="yesterday"){
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = " date(date) = '$yesterday_date' and";
			$where_a = " a.date_a = '$yesterday_date' " ;
		}else if($type=="last_week"){
			$where = " date >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY AND date < curdate() - INTERVAL DAYOFWEEK(curdate())- 2 DAY and " ;
			$where_a = " a.date_a >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY AND a.date_a < curdate() - INTERVAL DAYOFWEEK(curdate())- 2 DAY" ;
		}else if($type=="last_month"){	
		    $where =" `date`  >= NOW() - INTERVAL 1 MONTH and" ;
			$where_a = " a.date_a  >= NOW() - INTERVAL 1 MONTH " ;	 
		}else if($type=="last_3_month"){
			$where =" `date`  >= NOW() - INTERVAL 3 MONTH and" ;	
			$where_a = " a.date_a  >= NOW() - INTERVAL 3 MONTH " ;	 
		}else if($type=="last_6_month"){
			$where =" `date`  >= NOW() - INTERVAL 6 MONTH and" ;	
            $where_a = " a.date_a  >= NOW() - INTERVAL 6 MONTH " ;
		}else if($type=="last_year"){
			$where =" `date`>= DATE_SUB(NOW(),INTERVAL 1 YEAR) and" ;	
            $where_a = " a.date_a  >= DATE_SUB(NOW(),INTERVAL 1 YEAR) " ;
		}else if($type=="date_range"){
			$from_date = $_GET["from"];
			$to_date = $_GET["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			$where = "date between '$from_date' AND '$to_date' and" ;
            $where_a = " a.date_a  between '$from_date' AND '$to_date' " ;
		}
	}else{
		$where = "";
		$sql = "SELECT * FROM call_log where  client_id = '$target_number'   $sql_campaign_id order by date desc ";
	}
		$sql = "SELECT * FROM call_log WHERE ".$where." client_id = '$target_number'   $sql_campaign_id order by date desc ";
		$sql_pie_call = "SELECT count(*) as `call` FROM `call_log` WHERE ".$where." `client_id`='$target_number' and `status_code` in(0,1) $sql_campaign_id   union all SELECT count(*) as `call` FROM `call_log` WHERE ".$where."  `client_id`='$target_number' and `status_code` = 1  $sql_campaign_id  union all SELECT count(*) as `call` FROM `call_log` WHERE ".$where."  `client_id`='$target_number' and `status_code` = 0  $sql_campaign_id " ;
		$sql_pie_avg = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`duration`))/COUNT(*)) AS `avg_time` FROM `call_log` WHERE ".$where."  `client_id`='$target_number' and `status_code` in(0,1)  $sql_campaign_id " ;
		$sql_line = "select a.date_a as date_a, case when isnull(a.total_call) then 0 else a.total_call end total_call ,case when isnull(b.ans_call) then 0 else b.ans_call end ans_call, case when isnull(c.miss_call) then 0 else c.miss_call end miss_call from ((SELECT date(`date`) as date_a, count(*) as total_call FROM `call_log` where client_id = '$target_number' $sql_campaign_id group by date(`date`)) a LEFT JOIN (SELECT date(`date`) as date_b,count(*) as ans_call FROM `call_log` WHERE client_id = '$target_number' $sql_campaign_id and `status_code` = 1 group by date(`date`)) b on a.date_a = b.date_b left join (SELECT date(`date`) as date_c, count(*) as miss_call FROM `call_log` WHERE client_id = '$target_number' $sql_campaign_id and `status_code` = 0 group by date(`date`)) c on a.date_a = c.date_c) where ".$where_a." order by a.date_a desc";
		
	}else{
		$sql_pie_call = "SELECT count(*) as `call` FROM `call_log` WHERE `client_id`='$target_number' and `status_code` in(0,1) and `date` >= NOW() - INTERVAL 1 MONTH union all SELECT count(*) as `call` FROM `call_log` WHERE `client_id`='$target_number' and `status_code` = 1 and `date` >= NOW() - INTERVAL 1 MONTH union all SELECT count(*) as `call` FROM `call_log` WHERE `client_id`='$target_number' and `status_code` = 0 and `date` >= NOW() - INTERVAL 1 MONTH " ;
		$sql_pie_avg = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`duration`))/COUNT(*)) AS `avg_time` FROM `call_log` WHERE `client_id`='$target_number' and `status_code` in(0,1) and `date` >= NOW() - INTERVAL 1 MONTH " ;
		$sql = "SELECT * FROM call_log where client_id = '$target_number' and `date` >= NOW() - INTERVAL 12 MONTH order by date desc ";
		$sql_line = "select a.date_a as date_a, case when isnull(a.total_call) then 0 else a.total_call end total_call ,case when isnull(b.ans_call) then 0 else b.ans_call end ans_call, case when isnull(c.miss_call) then 0 else c.miss_call end miss_call from ((SELECT date(`date`) as date_a, count(*) as total_call FROM `call_log` where client_id = '$target_number' group by date(`date`)) a LEFT JOIN (SELECT date(`date`) as date_b,count(*) as ans_call FROM `call_log` WHERE client_id = '$target_number' and `status_code` = 1 group by date(`date`)) b on a.date_a = b.date_b left join (SELECT date(`date`) as date_c, count(*) as miss_call FROM `call_log` WHERE client_id = '$target_number' and `status_code` = 0 group by date(`date`)) c on a.date_a = c.date_c) where a.date_a >= NOW() - INTERVAL 12 MONTH order by a.date_a desc"; 
	}
	
	$rs_pie_chart = mysql_query($sql_pie_call);
	$rs_pie_avg = mysql_query($sql_pie_avg);
	$rs_line = mysql_query($sql_line);
    
	if(mysql_num_rows($rs_pie_chart)>0){   
		while($tmp_pie_chart = mysql_fetch_assoc($rs_pie_chart)){
			$call_detail[] = $tmp_pie_chart['call'];
		} 
	}
	
//	echo "total_call=".$call_detail[0]."</br>" ;
//	echo "answered_call=".$call_detail[1]."</br>" ;
//	echo "missed_call=".$call_detail[2]."</br>" ;
	
	if(mysql_num_rows($rs_pie_avg)>0){   
		while($tmp_pie_avg = mysql_fetch_assoc($rs_pie_avg)){
			$avg_call[] = $tmp_pie_avg['avg_time'];
		}
	}
//	echo "avg_call_duration=".$avg_call[0]."</br>" ;
			
	if(mysql_num_rows($rs_line)>0){   
		while($tmp_line_graph = mysql_fetch_assoc($rs_line)){
			$date_a[] = $tmp_line_graph['date_a'];
			$total_call[] = $tmp_line_graph['total_call'];
			$ans_call[] = $tmp_line_graph['ans_call'];
			$miss_call[] = $tmp_line_graph['miss_call'];
		} 
	}
	
//	echo " Line Graph : "."</br>";
//	echo "DATE"." : "."TOTAL_CALL"." : "."ANS_CALL"." : "."MISS_CALL"."</br>" ;
////		  
//	$i=0;
//	foreach ($date_a as $date_a_value) {
//    	echo    $date_a_value." : ".$total_call[$i]." : ".$ans_call[$i]." : ".$miss_call[$i]."</br>" ;
//	   	$i++;
//	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO Call Tracking</title>
<style>
.icons { background: url("Images/calls_icon.png") repeat scroll 0 0 rgba(0, 0, 0, 0); height: 42px; left: 42%; position: absolute; top: -9%; width: 42px;}
.content1{}
.content2{background-position: 0 141px;}
.content3{background-position: 0 91px;}
.content4{background-position: 0 41px;}

</style>
<?php include('head_include.php');?>

<script type="text/javascript">
$(document).ready(function(){
<?php 

$str = $avg_call[0];

//echo $str;

list($hour, $minute, $second) = explode(":", $str);
if($minute == 00 || $minute == '' && $second == 00 || $second == ''){
	$var = '00:00';
}else{
	if($hour != 00){
		$var = $hour.':'.$minute.':'.$second;
	} else {
		$var = $minute.':'.$second;
	}
}
	
?>
	$(".hideIfNotLoaded1").text('<?php echo $call_detail[0]; ?>');
	$(".hideIfNotLoaded2").text('<?php echo $call_detail[1]; ?>');
	$(".hideIfNotLoaded3").text('<?php echo $call_detail[2]; ?>');
	$(".hideIfNotLoaded4").text('<?php echo $var; ?>');
});
</script>
</head>
<body class="hybrid" style="overflow-x:hidden; padding-right:10%;">
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
                                            <a href="javascript:void(0)" id="show-filter-form">Filters <span class="icon-arrow"></span></a>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div id="filter-form" class="filter-form item-hide">
                                    <form method="get">
                                    	<input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                                    	<div>
                                    		<div class="frm_cont_top">
                                    			<label class="filter_lbl_view">View: </label>
                                     			<?php
                                               		$sql_camp = "SELECT * FROM campaign where client_id = '$target_number' ";
                                                    $rs_call_camp = mysql_query($sql_camp) or die ( mysql_error() );
                                                ?>
                                                <select name="campaign_id">
                                                	<option value="">All Campaigns</option>
                                                    <?php
                                                    	if(mysql_num_rows($rs_call_camp)>0){
                                                      		$i=1;
                                                            while($row_camp = mysql_fetch_assoc($rs_call_camp)){
                                                            	$selected = '';
                                                                if($selected==""){
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
                                                    <option value="">All</option>    
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="today"){echo "selected"; } ?> value="today">Today</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Month</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Month</option>
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
                                                    <option <?php if(isset($_GET["type"]) and $_GET["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
                                     			</select>
                                                &nbsp;
                                    		</div>
                                    		<div class="frm_cont_range" <?php if(isset($_GET["type"]) and $_GET["type"]=="date_range"){  }else{ ?> style="display:none" <?php } ?> id="date_range">    
                                                <div class="from-wrap">
                                                    <label class="from-range">From: </label>
                                                    <input type="text" id="from" name="from" value="<?php if(isset($_GET["from"])){ echo $_GET["from"];   }?>" />
                                                </div>
                                                <div class="clearB"></div>
                                                <div class="to-wrap">
                                                    <label class="to-range">To: </label>
                                                    <input type="text" id="to" name="to" value="<?php if(isset($_GET["to"])){ echo $_GET["to"];   }?>" />
                                                </div>
                                            </div>
                                            <div class="frm_buttons">
                                                <input type="submit" value="Apply Filters" class="active_btn" name="search"  id="cmd_filter">
                                                <input type="submit" id="cmd_default" class="default_btn" value="Reset to Default">
                                            </div>
                                    </div>
                              	</form>
                                </div>
                                </div>		
                            </div>
							<div class="filter-box-bg item-hide"></div>
							<div class="clearB"></div>
                            <div class="chart-box">
                            	<?php include('calls_chart.php'); ?>
                                <div class="doughnut_charts">
                                    <div class="doughnut_items_wrap">
                                        <div class="total_call_wrap doughtnut">
                                            <div id="chartdiv2" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                                            <div class="doughnut-img-wrap"><div class="icons content1"></div></div>
                                            <span class="hideIfNotLoaded1 hidden item_details"></span>
                                            <h5>Total Calls</h5>
                                            
                                        </div>
                                        <div class="ans_call_wrap doughtnut">
                                            <div id="answeredchartdiv2" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                                            <div class="doughnut-img-wrap"><div class="icons content2"></div></div>
                                            <span class="hideIfNotLoaded2 hidden item_details"></span>
                                            <h5>Answered Calls</h5>
                                        </div>
                                        <div class="miss_call_wrap doughtnut">
                                            <div id="missedchartdiv2" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                                            <div class="doughnut-img-wrap"><div class="icons content3"></div></div>
                                            <span class="hideIfNotLoaded3 hidden item_details"></span>
                                            <h5>Missed Calls</h5>
                                        </div>
                                        <div class="avg_call_wrap doughtnut">
                                            <div id="averagechartdiv2" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                                            <div class="doughnut-img-wrap"><div class="icons content4"></div></div>
                                            <span class="hideIfNotLoaded4 hidden item_details"></span>
                                            <h5>Average Call Duration</h5>
                                        </div>
                                    </div>
                                    <div class="clearB"></div>
                                    <!--<div class="line-legend">
                                        <ul>
                                            <li class="total_call"><em></em>Total Calls</li>
                                            <li class="miss_call"><em></em>Missed Calls</li>
                                            <li class="answered_call"><em></em>Answered Calls</li>
                                        </ul>
                                    </div>-->
                                    <div class="clearB"></div>
                                    <!--<div class="linegrap-wrap"><div id="linechartdiv2" style="width: 100%; height: 300px; background-color: #FFFFFF;" ></div></div>-->
                                    <div class="linegrap-wrap"><div id="linechartdiv3" style="width: 100%; height: 300px; background-color: #FFFFFF;" ></div></div>
                                </div>
                            </div>
							<div class="clearB"></div>
                        	<table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                                <thead>
                                    <tr>
                                       <th width="150">Date</th>
                                        <th width="100">Caller</th>
                                        <th width="100">Duration</th>
                                       <!-- <th>Answert Point</th>-->
                                        <th width="230">Location</th>
                                        <th>Status</th>
                                        <th>Download</th>
                                       <!-- <th>Recording</th>-->
                                        <th>Play</th>
                                    </tr>
                                </thead>
                            <tbody>
                            <?php
								$rs_call_log = mysql_query($sql) or die ( mysql_error() );
								if(mysql_num_rows($rs_call_log)>0){
									$i=1;
									while($row = mysql_fetch_assoc($rs_call_log)){
										$date = $row["date"];
										$d = date("d",strtotime($date));
										$date_prefix = addOrdinalNumberSuffix($d);
						
							?>
                            	<tr class="odd">
                                    <td class="date_data"><?php  echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date)); ?><!--5th May '14 - 11:58:01--></td>
                                    <td><?php echo $row["caller_number"]; ?></td>
                                    <td class="time_data"><?php echo $row["duration"];?></td>
                                    <td><?php echo $row["location"]; ?> , <?php echo $row["state"]; ?> ,<?php echo $row["country"]; ?></td>
                                    <td class="call_data"><?php echo $row["status_name"]; ?></td>
                                   	<!-- <td align="center"><img src="Images/call-tracking-icon-2.png" /></td>-->
                                    <td>
                                    	<?php
											$caller_id = $row["caller_id"];
                                    		$save_path = "audio/$caller_id.wav";
                                    		if(file_exists($save_path)){
                                    	?>
                                    			<a class="dwnload-btn" href="download.php?path=<?php echo $save_path;?>" target="_blank"> <img src="Images/call-tracking-icon-3.png" /></a>
                                    	<?php } ?>
                                    </td>
                                    <td>
                                    	<a href="#modal_<?php echo $i;?>" class="inline<?php echo $i;?>" onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>', 'inline<?php echo $i;?>');" data-reveal-id="modal_<?php echo $i;?>"><img src="Images/btn-play.png" /></a>
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
	if(mysql_num_rows($rs_call_log)>0){
		$i=1;
		while($row = mysql_fetch_assoc($rs_call_log)){
			$date = $row["date"];
			$d = date("d",strtotime($date));
			$date_prefix = addOrdinalNumberSuffix($d);
			$caller_id = $row["caller_id"];
?>
	<div style="display:none;" >
	<div id="modal_<?php echo $i;?>" class="item_modals">
   	<!--<div align="right">
 	<a href="#"  onClick="return close_open_model('modal_<?php //echo $i;?>','<?php //echo $caller_id;?>');">Close</a>
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
                    <td align="left"> <?php echo $row["target_number"]; ?> - <?php  echo $row["target_name"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Location:</b></td>
                    <td align="left"><?php echo $row["location"]; ?> ,<?php echo $row["state"]; ?> ,<?php echo $row["country"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Status:</b></td>
                    <td align="left"><?php echo $row["status_name"]; ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Duration:</b></td>
                    <td align="left"><?php echo $row["duration"];?></td>
                </tr>
                <tr>
                    <td align="right"><b>Audio/File:</b></td>
                    <td align="left">
					<?php $save_path = "audio/$caller_id.wav";
						if(file_exists($save_path)){
					?>
                    <!-- <audio controls id="yourAudio_<?php //echo $caller_id;?>">                           
                            <source src="<?php //echo  $save_path;?>" type="audio/wav">
                            Your browser does not support the audio element. </audio>-->
                    		<span id="player_<?php echo $caller_id;?>"></span>
                            <a style=" position:relative; top:3px;" id="play_link_<?php echo $caller_id;?>" onClick="return play_audio('player_<?php echo $caller_id;?>','yourAudio_<?php echo $caller_id;?>','<?php echo  $save_path;?>','play_link_<?php echo $caller_id;?>');"  href="javascript:void(0);">Play</a>
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


</body>
</html>