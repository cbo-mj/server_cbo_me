<?php
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");

	$client_id = $_GET["id"];
	$sql_client = "select distinct account_id , profile_id from client where client_id = '$client_id' and  account_id!='' and profile_id!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
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

<body class="hybrid" style="overflow-x:hidden;">

<div id="wrapper">
    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                        <div class="container" style="margin:0 auto !important;">                        
                            <div class="filter-box">        
                                <div class="filter-form-wrap">		
                                    <div class="filter-text">
                                        <div class="bg-white">
                                            <a href="javascript:void(0)" id="show-filter-form">Filters <span class="icon-arrow"></span></a>				
                                        </div>
                                        <div class="line"></div>
                                    </div><!-- END FILTER TEXT -->
                                    <div id="filter-form" class="filter-form item-hide">  
                                        <form method="post">
                                            <div>     
												<?php $sql_check_account = " SELECT * FROM  `ga_account`  where account_id = '$account_id' "; ?>              
													<?php $rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
                                                            if(mysql_num_rows($rs_account)>0){
                                                            	while($ga_account_detail = mysql_fetch_assoc($rs_account)){?>
                                                                   
													<input type="hidden" name="accountSelector" value="<?php echo $ga_account_detail['account_id'];?>" />
													<?php }}?>       
                                                <!--</div>--><!-- END .frm_cont_top -->
   												<?php
                                                    $firstAccountId = $account_id;
                                                     $sql_check_account = "SELECT * FROM  `ga_property` where account_id = '$firstAccountId' and profile_id = '$profile_id'";
                                                ?>
                                                
                                                <input type="hidden" value="<?php echo $profile_id;?>" name="webproperty-dd" />
                                                
                                                <div class="frm_cont_top" style="height:64px !important;">
                                                    <select name="type" onChange="return check_date_range(this.value);" id="timeframe" >
                                                        <option value="">Please select</option>    
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">&nbsp;Yesterday</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_week"){echo "selected"; } ?> value="last_week">&nbsp;Last Week</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_month"){echo "selected"; } ?> value="last_month">&nbsp;Last Month</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">&nbsp;Last 3 Months</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">&nbsp;Last 6 Months</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_year"){echo "selected"; } ?> value="last_year">&nbsp;Last Year</option>        
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){echo "selected"; } ?> value="date_range">&nbsp;Date Range</option>        
                                                    </select>
                                                </div><!-- END .frm_cont_top -->
                                                
                                                <div class="frm_cont_range" <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){  }else{ ?> style="display:none" <?php } ?> id="date_range">    
                                                    <div class="from-wrap">
                                                        <label class="from-range">From: </label>
                                                        <input type="text" id="from" name="from" value="<?php if(isset($_POST["from"])){ echo $_POST["from"];   }?>" />
                                                    </div>
                                                    <div class="clearB"></div>
                                                    <div class="to-wrap">
                                                        <label class="to-range">To: </label>
                                                        <input type="text" id="to" name="to" value="<?php if(isset($_POST["to"])){ echo $_POST["to"];   }?>" />
                                                    </div>
                                                </div>  <!-- END .frm_cont_top -->      
                                                <div class="frm_buttons">        
                                                <input class="active_btn" type="submit" name="submit" value="Apply Filter"> 
                                                <input class="default_btn" type="button" value="Reset to Default" onClick="window.location.href=window.location.href">
                                                </div> 
                                            </div>       
                                        </form>
                                    </div><!-- END #fitler-form -->
                                </div><!-- END .filter-form-wrap -->
                            </div><!-- END .filter-box -->
                            <div id="filter-form" class="filter-form item-hide"></div>
                            <div class="clearB"></div>
                        </div>		
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
			$date_sql = " and date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY	";
		}else if($type=="last_month")
		{	
			$date_sql = " and YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
		}else if($type=="last_3_month")
		{
			$date_sql = "  and date(date ) >= now()-interval 3 month		";
		}else if($type=="last_6_month")
		{
			$date_sql = "  and date(date ) >= now()-interval 6 month		";
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
		 if($type=="yesterday") { 
			       $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql union all
					 select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id' $date_sql ";
			 }else {
			 
		 $sql = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql ";
			 }
		
	  $sql_device =  "select ga_deviceCategory,COUNT(*) as total from all_ga_data_platform_history where account_id = '$account_id' and 	profile_id = '$profile_id' $date_sql group by ga_deviceCategory";
	 
		$sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
 group by yearmonth order by date asc" ; 

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
				$day_pageview[] = $ga_30_days_detail['ga_pageviews'];
				$day_date[] = $ga_30_days_detail['date'];
				$day_session[] = $ga_30_days_detail['ga_sessions'];
				
				$total_count += $ga_30_days_detail['ga_newUsers'];
				$total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
				$total_ga_visits += $ga_30_days_detail['ga_visits'];
				$total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
				$total_ga_avgSessionDuration+= $ga_30_days_detail['ga_avgSessionDuration'] ;
			}
				$avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
				$avg_ga_pageviews_day = $total_ga_pageviews/$total_ga_visits ;
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
	$sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' union all select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id'";
    $sql_device =  "select ga_deviceCategory,COUNT(*) as total from ga_data_platform_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' group by ga_deviceCategory";
	$sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
group by yearmonth order by date asc" ;

    $rs_30_days = mysql_query($sql) or die ( mysql_error() );	
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
				$day_pageview[] = $ga_30_days_detail['ga_pageviews'];
				$day_date[] = $ga_30_days_detail['date'];
				$day_session[] = $ga_30_days_detail['ga_sessions'];
				$total_count += $ga_30_days_detail['ga_newUsers'];
				$total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
				$total_ga_visits += $ga_30_days_detail['ga_visits'];
				$total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
				$total_ga_avgSessionDuration+= $ga_30_days_detail['ga_sessionDuration']/$ga_30_days_detail['ga_sessions'];
			}
				$avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
				$avg_ga_pageviews_day = $total_ga_pageviews/$total_ga_visits ;
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

?>

<style>
.piechart h1,.piechart h6{text-align:center;padding-right:0}.piechart{width:16.6%;float:left;position:relative}.chart_holder{width:100%;height:150px;margin:0 auto}#VisitorsChart{background:url(icons/new-visitors-icon.png) center center no-repeat;background-size:34px 34px}#BounceRateChart{background:url(icons/bounce-rate-icon.png) center center no-repeat;background-size:34px 34px}#TotalVisits{background:url(icons/visits-icon.png) center center no-repeat;background-size:34px 34px}#PageViews{background:url(icons/pageviews-icon.png) center center no-repeat;background-size:34px 34px}#AvePageViews{background:url(icons/avg-pageviews-icon.png) center center no-repeat;background-size:34px 34px}#AveTime{background:url(icons/avg-time-iconss.png) center center no-repeat;background-size:34px 34px}h6.device_name{text-transform:capitalize}#PieChartContainer{width:350px;float:right}.piechart2{width:115.5px;float:left;position:relative}.piechart2 h1,.piechart2 h3,.piechart2 h6{text-align:center;padding-right:0}.piechart2 img{position:absolute;top:25px;left:9px}.chart_holder2{width:100%;height:150px;margin:0 auto}#desktop{background:url(icons/desktop-icon.png) center center no-repeat;background-size:34px 34px}

/*.frm_cont_top > select{ font:11px/12px Verdana, Arial, sans-serif; }
.frm_cont_top option{ margin:0.3em 0.5em; padding:2px 0 2px 2px !important; color:#1e86e3;}*/

	#mobile {
	<?php 
		 //$mobile = round($total_device_count[0]*100/$total_val);
		 $mobile = round($total_device_count[2]*100/$total_val) + round($total_device_count[0]*100/$total_val);
		 $mobile2 = ".{$mobile}";
		 $mobile3 = 360 * $mobile2;
	?>	
		-webkit-transform: rotate(<?php echo $mobile3.'deg'; ?>); /* Safari and Chrome */
		-moz-transform: rotate(<?php echo $mobile3.'deg'; ?>);   /* Firefox */
		-ms-transform: rotate(<?php echo $mobile3.'deg'; ?>);   /* IE 9 */
		-o-transform: rotate(<?php echo $mobile3.'deg'; ?>);   /* Opera */
		transform: rotate(<?php echo $mobile3.'deg'; ?>);

	}
	#tablet {
	<?php 
		 //$tablet = round($total_device_count[1]*100/$total_val) + round($total_device_count[0]*100/$total_val);
		 //$tablet2 = ".{$tablet}";
		 //$tablet3 = 360 * $tablet2;
		 
		 $tablet = round($total_device_count[0]*100/$total_val);
		 $tablet2 = ".{$tablet}";
		 $tablet3 = 360 * $tablet2;
	?>	
		-webkit-transform: rotate(<?php echo $tablet3.'deg'; ?>); /* Safari and Chrome */
		-moz-transform: rotate(<?php echo $tablet3.'deg'; ?>);   /* Firefox */
		-ms-transform: rotate(<?php echo $tablet3.'deg'; ?>);   /* IE 9 */
		-o-transform: rotate(<?php echo $tablet3.'deg'; ?>);   /* Opera */
		transform: rotate(<?php echo $tablet3.'deg'; ?>);

	}	
	
	#main_container{ max-width:1200px; margin:0 auto;}
	#StockChart { width	: 92%; height	: 500px; margin:0 auto; }
		
	@media only screen and (min-device-width:1280px) and (max-device-width:1366px){
		#main_container{ width:920px;}
	}
	
	span.TotalVisitors:hover, span.PageViews:hover, span.NewVisitors:hover, span.BounceRate:hover, span.AvgPagesViewed:hover, span.AvgTime:hover{ cursor:help;}
</style>
<?php include('piechart.php');?>
<div id="main_container">
<div class="piechart"> 
	<div id="TotalVisits" class="chart_holder"></div>
	<h1><?php $ans = $total_count + $total_ga_visits; $ans2 = number_format($ans); echo $ans2; ?></h1>
	<h6><span class="TotalVisitors" title="The total number of people <br />who have been to the site.">Total Visitors</span></h6>
</div>
<div class="piechart"> 
	<div id="PageViews" class="chart_holder"></div>
	<h1><?php $total_ga_pageviews; $total_views = number_format($total_ga_pageviews); echo $total_views; ?></h1>
	<h6><span class="PageViews" title="The number of web pages <br />viewed within your site.">Page Views</span></h6>
</div>
<div class="piechart"> 
	<div id="VisitorsChart" class="chart_holder"></div>
	<h1><?php $total_count; $total_c = number_format($total_count); echo $total_c; ?></h1>
	<h6><span class="NewVisitors" title="A visitor that has not been <br />to your website before.">New Visitors</span></h6>
</div>
<div class="piechart"> 
	<div id="BounceRateChart" class="chart_holder"></div>
	<h1><?php echo $avg_ga_bounce.'%';?></h1>
	<h6><span class="BounceRate" title="The percentage of people who leave the <br />site on the same page they arrived on.">Bounce Rate</span></h6>
</div>
<div class="piechart"> 
	<div id="AvePageViews" class="chart_holder"></div>
	<h1><?php echo round($avg_ga_pageviews_day, 2);?></h1>
	<h6><span class="AvgPagesViewed" title="The average number of pages a <br />visitors views per session.">Avg. Pages Viewed</span></h6>
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
	<h6><span class="AvgTime" title="The average time spent on <br />your site per user.">Avg. Time (min)</span></h6>
</div>




<div style="clear:both;"></div>

<?php include('stockchart.php'); ?>
<div id="StockChart"></div>	
<br/>
<hr/>
<br/>

<?php  include('columnchart.php');?>

<div style="width: 60%; height: 240px; background-color: #FFFFFF; float:left; position:relative; padding-top:20px;">
<h6 style="position:absolute; left:0; top:0;">Sessions by Month</h6>
    <div id="ColumnChart" style="width:100%; height:240px;"></div>
</div>	

<div id="PieChartContainer">
<h6>Devices</h6>
    <div class="piechart2"> 
    	<div id="<?php echo $device_name[0]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[0]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[0]; ?></h6>
    </div>
    <div class="piechart2">
    	<img src="icons/tablet-icons.png" alt="phone" /> 
        <div id="<?php echo $device_name[2]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[2]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[2]; ?></h6>
    </div>
    <div class="piechart2"> 
    	<img src="icons/phone-icons.png" alt="phone" />
        <div id="<?php echo $device_name[1]; ?>" class="chart_holder2"></div>
        <h1><?php echo round($total_device_count[1]*100/$total_val).'%<br/>'; ?></h1>
        <h6 class="device_name"><?php echo $device_name[1]; ?></h6>
    </div>
</div>
<div style="clear:both;"></div>
<br />

</div>
</div>
</body>
</html>