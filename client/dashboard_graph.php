<?php
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");

	$client_id = $_GET["id"];
	
	$sql_client = "select * from client where client_id = '$client_id'  ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
		 $account_id = $client_detail['account_id'];
		 
		 $profile_id = $client_detail['profile_id'];
		  
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>
<?php include('head_include.php');?>
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
				<a href="javascript:void(0)" id="show-filter-form">Filters <span class="icon-arrow"></span></a>
				
			</div>
			<div class="line"></div>
		</div>
        
        <div id="filter-form" class="filter-form item-hide">
        
		<form method="post">
        
  	<div class="frm_cont_top">
    
    
    
    <label class="filter_lbl_view">Account: </label>
    <select name="accountSelector"  >
             
     <?php
	$sql_check_account = 
						"
						SELECT * 
						FROM  `ga_account`  where account_id = '$account_id' 
						";
										
	$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_account)>0)
	{
	 while($ga_account_detail = mysql_fetch_assoc($rs_account))
	 {
	?>
		<option <?php if($_POST['accountSelector']==$ga_account_detail['account_id']){ echo 'selected';}?> value="<?php echo $ga_account_detail['account_id'];?>"><?php echo $ga_account_detail['account_name'];?></option>
	
    
    <?php
	}
}
	?>	
    
        
        
    
    </select>
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

   
   
   </script>
    
    
	
	
    <div class="frm_cont_top">
    <span id="ajax_result">
    
       
    
  

    
    
    <label class="filter_lbl_view">Property: </label>
	<select name="webproperty-dd" >
    <?php
	$firstAccountId = $account_id;
	
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
		 
		// pr($ga_property_detail);
		 
	?>
		<option <?php if($_POST['webproperty-dd']==$ga_property_detail['profile_id']){ echo 'selected';}?> value="<?php echo $ga_property_detail['profile_id'];?>"><?php echo $ga_property_detail['property_name'];?></option>
	
    
    <?php
	}
}
	?>	
    
</select>
    

    
    
    </span>
    
    
    
    
 
 </div>
 
 <div class="frm_cont_top">
 <select name="type" onChange="return check_date_range(this.value);" >
				<option value="">Please select</option>    
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="today"){echo "selected"; } ?> value="today">Today</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Month</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Month</option>
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
				<option <?php if(isset($_GET["type"]) and $_GET["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
			</select>
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
        
   <label class="filter_lbl_view"><input type="submit" name="submit" value="Search"> </label>
    


</form>


</div>		
        </div>
        
</div>		
</div>
<div style="clear:both;"></div>
<div>


<?php

$total_count = '';
$total_ga_bounce = '';
$total_ga_visits = '';
$total_ga_pageviews = '';
$total_ga_avgSessionDuration = '';
$avg_ga_bounce = '';
$avg_ga_pageviews_day = '';
$avg_ga_avgSessionDuration = '';


if(isset($_POST["submit"]))
{
	$date_sql = '';	
		
	 if($_POST["webproperty-dd"]!="")
	 {
		 
		 
	if(isset($_POST["type"]) and $_POST["type"]!="")
	{
		$type = $_POST["type"];
	
		// today day
	
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$date_sql = "and date(date) = '$today_date' ";
			
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$date_sql = "and date(date) = '$yesterday_date' ";
			
			
		}else if($type=="last_week")
		{
			
			$date_sql = " and date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
					 AND date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY	";
			
			
		}else if($type=="last_month")
		{	
					 
			$date_sql = " and YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
			
			
		}else if($type=="last_3_month")
		{
				 
					 
			$date_sql = " and  MONTH( date ) >= MONTH( CURDATE( ) ) -3	";
					 
			
		}else if($type=="last_6_month")
		{
			
			$date_sql = " and  MONTH( date ) >= MONTH( CURDATE( ) ) -6	";
			
			
		}else if($type=="last_year")
		{
			$date_sql = " and  date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)		";
				
				
		}else if($type=="date_range")
		{
			
			$from_date = $_POST["from"];
			$to_date = $_POST["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			$date_sql = " and  date between '$from_date' AND '$to_date'		";
				
		}
	
	}
		 
		 // $date_sql
	 
	 	 $account_id = $_POST['accountSelector'];
		 $profile_id = $_POST['webproperty-dd'];
		 
		 if($date_sql=="")
		 {
	
		 $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' union all
		 select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id'";
	   $sql_device =  "select ga_deviceCategory,COUNT(*) as total from ga_data_platform_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' group by ga_deviceCategory";
		$sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
group by yearmonth order by date asc" ;

		$rs_30_days = mysql_query($sql);
		
		$rs_device_30_days = mysql_query($sql_device);
		
		$rs_year_session = mysql_query($sql_session);
		
		 }else{
			 
			 
		 $sql = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql ";
		
	  $sql_device =  "select ga_deviceCategory,COUNT(*) as total from all_ga_data_platform_history where account_id = '$account_id' and 	profile_id = '$profile_id' $date_sql group by ga_deviceCategory";
	 
		$sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
 $date_sql group by yearmonth order by date asc" ; 


		$rs_30_days = mysql_query($sql);
		$rs_device_30_days = mysql_query($sql_device);
		$rs_year_session = mysql_query($sql_session);
			 
		 }
		
		
		if(mysql_num_rows($rs_year_session)>0)
				{   
			 		while($ga_365_session_detail = mysql_fetch_assoc($rs_year_session))
			 		{
						$year_month[] = $ga_365_session_detail['yearmonth'];
						$total_session[] = $ga_365_session_detail['totalsession'];
					}
		        }

		if(mysql_num_rows($rs_30_days)>0)
		{
			 
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days))
			{
				$day_date[] = $ga_30_days_detail['date'];
				$day_session[] = $ga_30_days_detail['ga_sessions'];
				
				$total_count += $ga_30_days_detail['ga_newUsers'];
				$total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
				$total_ga_visits += $ga_30_days_detail['ga_visits'];
				$total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
				$total_ga_avgSessionDuration+= $ga_30_days_detail['ga_sessionDuration']/$ga_30_days_detail['ga_sessions'];
			}
				$avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
				$avg_ga_pageviews_day = $total_ga_pageviews/mysql_num_rows($rs_30_days);
				$avg_ga_avgSessionDuration = $total_ga_avgSessionDuration/mysql_num_rows($rs_30_days);
				$avg_ga_avgSessionDuration_h_i_s = gmdate("H:i:s",$avg_ga_avgSessionDuration);
		 
			 
		}
				if(mysql_num_rows($rs_device_30_days)>0)
				{   
			 		while($ga_30_days_device_detail = mysql_fetch_assoc($rs_device_30_days))
			 		{
						
						$device_name[] = $ga_30_days_device_detail['ga_deviceCategory'];
						$total_device_count[] = $ga_30_days_device_detail['total'];
						$total_val+= $ga_30_days_device_detail['total'];
					}
		        }
	 }
	 
}else{
	
	  $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' union all
		 select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id'";
	   $sql_device =  "select ga_deviceCategory,COUNT(*) as total from ga_data_platform_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' group by ga_deviceCategory";
		$sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
group by yearmonth order by date asc" ;




		$rs_30_days = mysql_query($sql) or die ( mysql_error() );	
		
		
//echo mysql_num_rows($rs_30_days); die;
		
		$rs_device_30_days = mysql_query($sql_device) or die ( mysql_error() );	
		
		$rs_year_session = mysql_query($sql_session) or die ( mysql_error() );	
	
	
	if(mysql_num_rows($rs_year_session)>0)
				{   
			 		while($ga_365_session_detail = mysql_fetch_assoc($rs_year_session))
			 		{
						$year_month[] = $ga_365_session_detail['yearmonth'];
						$total_session[] = $ga_365_session_detail['totalsession'];
					}
		        }

		if(mysql_num_rows($rs_30_days)>0)
		{
			
			 
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days))
			{
				
				
		/*	print_r("<pre>");
			print_r($ga_30_days_detail);*/
			
				$day_date[] = $ga_30_days_detail['date'];
				$day_session[] = $ga_30_days_detail['ga_sessions'];
				$total_count += $ga_30_days_detail['ga_newUsers'];
				$total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
				$total_ga_visits += $ga_30_days_detail['ga_visits'];
				$total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
				$total_ga_avgSessionDuration+= $ga_30_days_detail['ga_sessionDuration']/$ga_30_days_detail['ga_sessions'];
			}
			
			
		/*	print_r("<pre>");
			print_r($day_date);
			
			print_r("<pre>");
			print_r($day_session);
			echo 'kkkkkkkkkkkkkkkkkkk'; die;*/
			
				$avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
				$avg_ga_pageviews_day = $total_ga_pageviews/mysql_num_rows($rs_30_days);
				$avg_ga_avgSessionDuration = $total_ga_avgSessionDuration/mysql_num_rows($rs_30_days);
				$avg_ga_avgSessionDuration_h_i_s = gmdate("H:i:s",$avg_ga_avgSessionDuration);
		 
			 
		}
				if(mysql_num_rows($rs_device_30_days)>0)
				{   
			 		while($ga_30_days_device_detail = mysql_fetch_assoc($rs_device_30_days))
			 		{
						
						$device_name[] = $ga_30_days_device_detail['ga_deviceCategory'];
						$total_device_count[] = $ga_30_days_device_detail['total'];
						$total_val+= $ga_30_days_device_detail['total'];
					}
		        }
	
	
	
}

//pr($device_name);
?>

<!--
<div><strong>New Visitors</strong> &nbsp; : <?php //echo $total_count;?> </div>
<div><strong>Bounce Rate</strong> &nbsp; : <?php //echo $avg_ga_bounce."%";?> </div>
<div><strong>Visits</strong> &nbsp; : <?php //echo $total_ga_visits;?> </div>
<div><strong>Page Views</strong> &nbsp; : <?php //echo $total_ga_pageviews;?> </div>
<div><strong>Ave. Pages Views/Day</strong> &nbsp; : <?php //echo $avg_ga_pageviews_day;?> </div>
<div><strong>Ave. Time</strong> &nbsp; : <?php //echo $avg_ga_avgSessionDuration_h_i_s;?> </div>-->

<?php include('piechart.php');?>
<style>
	.piechart h1, .piechart h6{ text-align:center; }
	.piechart{ width:16.6%; float:left; position:relative; }
	.chart_holder{ width: 200px; height: 200px; margin:0 auto;  }
	#VisitorsChart{ background:url(icons/new-visitors-icon.png) center center no-repeat; background-size:34px 34px;}
	#BounceRateChart{ background:url(icons/bounce-rate-icon.png) center center no-repeat; background-size:34px 34px;}
	#TotalVisits{ background:url(icons/visits-icon.png) center center no-repeat; background-size:34px 34px;}
	#PageViews{ background:url(icons/pageviews-icon.png) center center no-repeat; background-size:34px 34px;}
	#AvePageViews{ background:url(icons/avg-page-viewed-icon.png) center center no-repeat; background-size:34px 34px;}
	#AveTime{ background:url(icons/avg-time-icon.png) center center no-repeat; background-size:34px 34px;}
	h6.device_name{ text-transform:capitalize;}
	#PieChartContainer{ width:500px; float:right;}
	.piechart2{ width:33.3%; float:left; position:relative; }
	.piechart2 h1, .piechart2 h6{ text-align:center; }
	.chart_holder2{ width: 100%; height: 150px; margin:0 auto;  }
	#desktop{ background:url(icons/desktop-icon.png) center center no-repeat; background-size:34px 34px;} 
	#mobile{ background:url(icons/mobile-icon.png) center center no-repeat; background-size:34px 34px;} 
	#tablet{ background:url(icons/tablet-icon.png) center center no-repeat; background-size:34px 34px;} 
	#mobile {
		-webkit-transform: rotate(180deg); /* Safari and Chrome */
		-moz-transform: rotate(180deg);   /* Firefox */
		-ms-transform: rotate(180deg);   /* IE 9 */
		-o-transform: rotate(180deg);   /* Opera */
		transform: rotate(180deg);
	}
	#tablet {
		-webkit-transform: rotate(270deg); /* Safari and Chrome */
		-moz-transform: rotate(270deg);   /* Firefox */
		-ms-transform: rotate(270deg);   /* IE 9 */
		-o-transform: rotate(270deg);   /* Opera */
		transform: rotate(270deg);
	}	
	#main_container{ width:1200px; margin:0 auto;}	
</style>
<div id="main_container">
<div class="piechart"> 
	<div id="VisitorsChart" class="chart_holder"></div>
	<h1><?php echo $total_count;?></h1>
	<h6>New Visitors</h6>
</div>
<div class="piechart"> 
	<div id="BounceRateChart" class="chart_holder"></div>
	<h1><?php echo $avg_ga_bounce.'%';?></h1>
	<h6>Bounce Rate</h6>
</div>
<div class="piechart"> 
	<div id="TotalVisits" class="chart_holder"></div>
	<h1><?php echo $ans = $total_count + $total_ga_visits;?></h1>
	<h6>Total Visitors</h6>
</div>
<div class="piechart"> 
	<div id="PageViews" class="chart_holder"></div>
	<h1><?php echo $total_ga_pageviews;?></h1>
	<h6>Page Views</h6>
</div>
<div class="piechart"> 
	<div id="AvePageViews" class="chart_holder"></div>
	<h1><?php echo round($avg_ga_pageviews_day, 2);?></h1>
	<h6>Avg. Pages Viewed</h6>
</div>
<div class="piechart"> 
	<div id="AveTime" class="chart_holder"></div>
	<h1>
	<?php 
    
        $str = $avg_ga_avgSessionDuration_h_i_s;
        list($hour, $minute, $second) = explode(":", $str);
        
		if($hour != 00){
			echo $hour.':'.$minute.':'.$second;
		} else {
			echo $minute.':'.$second;
		}
    ?>
    </h1>
	<h6>Avg. Time (min)</h6>
</div>




<div style="clear:both;"></div>


<?php  include('linechart.php');?>

	<?php 
	
    $i=0;
/*	print_r("<pre>");//
	print_r($day_date);
	print_r($day_session); die;*/
    
    foreach($day_date as $value) {
        
    $date = $value;
    $new_date = str_replace("-", "", $date);
   
        echo  "date:".$new_date  ; echo "</br>";
        echo "Sessions:".$day_session[$i];  echo "</br>";
    $i++; }?>
            

		
<div id="linechartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;"></div>



<?php 


//$i=0;
//
//echo '<pre>';
//print_r($device_name);
//print_r($total_device_count);
//echo round($total_device_count[1]*100/$total_val)."%";
//echo '</pre>';
//
//
//echo '<hr/>';
//echo $device_name[0].'<br/>';
//echo $device_name[1].'<br/>';
//echo $device_name[2].'<br/>';
//
//echo '<hr/>';
//echo round($total_device_count[0]*100/$total_val).'%<br/>';
//echo round($total_device_count[1]*100/$total_val).'%<br/>';
//echo round($total_device_count[2]*100/$total_val).'%<br/>';
?>

<div id="PieChartContainer">
    <div class="piechart2"> 
        <div id="<?php echo $device_name[0]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[0]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[0]; ?></h6>
    </div>
    <div class="piechart2"> 
        <div id="<?php echo $device_name[1]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[1]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[1]; ?></h6>
    </div>
    <div class="piechart2"> 
        <div id="<?php echo $device_name[2]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[2]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[2]; ?></h6>
    </div>
</div>
<?
	//foreach($device_name as $value) {
?>
<!--<div><strong>Device Name</strong> &nbsp; : <?php //echo $value;?> </div>
<div><strong>Percentage </strong> &nbsp; : <?php //echo round($total_device_count[$i]*100/$total_val)."%";?> </div>-->

<?php //$i++;
//}?>
</div>

</div>

</body>




</html>