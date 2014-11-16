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

<style>
.filter-form{width:365px}#custom_drop_form{width:352px}.menu_container{position:absolute;width:220px;margin:-26px 0 0 165px;background:#FFF;z-index:1;border:1px solid #d3d3d3;display:none;padding-top:5px}.option{width:265px;margin:15px 0 18px 88px;position:relative}.option p{font:700 12px/1 Arial,Helvetica,sans-serif;width:76px;display:inline}h2#nav{margin-left:10px;border-radius:2px;width:186px;color:#000;line-height:25px;padding:5px 5px 5px 10px;cursor:pointer;border:1px solid #d3d3d3;font:12px/1 Arial,Helvetica,sans-serif;display:inline-block;text-transform:uppercase}ol.select{display:none;margin:5px 0 0 5px;width:200px}ol.select>li{line-height:20px;font-size:12px;padding:2px 4px;cursor:pointer;list-style:none}ol.select>li a{display:block;padding:0 5px;width:200px}ol.select>li a.ctive,ol.select>li a:hover{color:#FFF!important;display:block;width:200px;background:#1e86e3;border-radius:2px}#datepickerdivfrom,#datepickerdivto{font-size:9px;width:180px;float:left;position:relative}#datepickerdivfrom label,#datepickerdivto label{position:absolute;top:-13px;left:0;font:700 10px/1 Arial,Helvetica,sans-serif;width:69px}#date_picker_holder{width:360px;float:right;display:none;padding:20px 0 15px}.ui-datepicker th,.ui-state-default,.ui-widget-content .ui-state-default,.ui-widget-header .ui-state-default{font-size:9px!important}.activeClass{background:#1e86e3;border-radius:2px;color:#fff!important}a.activeClass,a:active.activeClassactive,a:hover.activeClassactive{color:#FFFFF!important}.piechart h1,.piechart h6{text-align:center;padding-right:0}.piechart{width:16.6%;float:left;position:relative}.chart_holder{width:100%;height:150px;margin:0 auto}.icons{width:34px;height:34px;position:absolute;left:42%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}h6.device_name{text-transform:capitalize}#PieChartContainer{width:350px;float:right}.piechart2{width:115.5px;float:left;position:relative}.piechart2 h1,.piechart2 h3,.piechart2 h6{text-align:center;padding-right:0}.piechart2 .icon_dev{position:absolute;top:60px;left:41px;width:34px;height:34px;background:url(icons/devices.png)}.icon_dev.img2{background-position:0 78px}.icon_dev.img3{background-position:0 34px}.chart_holder2{width:100%;height:150px;margin:0 auto}#desktop{background-size:34px 34px}#main_container{max-width:1200px;margin:0 auto}#StockChart{width:92%;height:500px;margin:0 auto}

@media only screen and (min-device-width:1280px) and (max-device-width:1366px) {#main_container{width:920px}.icons{width:34px;height:34px;position:absolute;left:40%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}
}
span.AvgPagesViewed:hover,span.AvgTime:hover,span.BounceRate:hover,span.NewVisitors:hover,span.PageViews:hover,span.TotalVisitors:hover{cursor:help}.arrow-down1{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:21px;top:7px}.arrow-down2{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:7px;top:13px}.bg-white{position:relative}
.amChartsPeriodSelector{ display:none;}
</style>
<?php include('head_include.php');?>

<script type="text/javascript">
AmCharts.themes.none = {};
</script>

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
                                            <a href="javascript:void(0)" id="show-filter-form">Filters <div class="arrow-down1"></div></a>				
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
                                                <!-- BEGIN OF NEW DROPDOWN FORM -->
                                                <div id="custom_drop_form">
                                                
                                                	<div class="option"><p>Date Period</p><h2 id="nav">Please Select</h2><div class="arrow-down2"></div></div>
                                                    <div style="clear:both;"></div>
                                                    <div class="menu_container">
                                                    	<div id="date_picker_holder">
                                                        	<div id="datepickerdivfrom">
                                                            	<label>Start Date:</label>
                                                                <input type="hidden" id="from" name="from" value="" />
                                                            </div>
                                                            <div id="datepickerdivto">
                                                            	<label>End Date:</label>
                                                                <input type="hidden" id="to" name="to" value="" />
                                                            </div>
                                                            <div style="clear:both"></div>
                                                            <input class="active_btn"  value="Done" style="float:right; cursor: pointer; margin-right: 11px; margin-top: 10px; width:50px;" onclick="onClose();" /> 
                                                        </div>
                                                    	<input type="hidden" id="specific_field" name="type" value="" />
                                                    	<ol class="select">
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "yesterday"; ?>');">Yesterday</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_week"; ?>');">Last Week</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_month"; ?>');">Last Month</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_3_months"; ?>');">Last 3 Months</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_6_months"; ?>');">Last 6 Months</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_year"; ?>');">Last Year</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "date_range"; ?>');" class="date_range">Date Range</a></li>
                                                        </ol>
                                                        
                                                        <div style="clear:both"></div>
                                                        
                                                    </div>
                                                </div>
                                                <input type="hidden" value="<?php echo $profile_id;?>" name="webproperty-dd" />
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
                                    $date_sql = " and date >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY AND date < curdate() - INTERVAL DAYOFWEEK(curdate())- 2 DAY	";
                                }else if($type=="last_month")
                                {	
                                    $date_sql = " and YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
                                }else if($type=="last_3_months")
                                {
                                    $date_sql = "  and date(date ) >= now()-interval 3 month		";
                                }else if($type=="last_6_months")
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
                                $date_sql2 = '';
                                $account_id = $_POST['accountSelector'];
                                $profile_id = $_POST['webproperty-dd'];
                                if($date_sql==""){
                                    $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' union all select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id'";
                                    $sql_d = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql2";
                                    $sql_device =  "select ga_deviceCategory,SUM(`ga_users`) as total from ga_data_platform_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' and ga_deviceCategory !='' group by ga_deviceCategory";
                                    $sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id' group by yearmonth order by date asc" ;
                        
                                    $rs_30_days = mysql_query($sql);
                                    $rs_all = mysql_query($sql_d);
                                    $rs_device_30_days = mysql_query($sql_device);
                                    $rs_year_session = mysql_query($sql_session);
                                
                                 }else{
                                    if($type=="yesterday") { 
                                        $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql union all
                                        select * from ga_todays_data where account_id = '$account_id' and 	profile_id = '$profile_id' $date_sql ";
                                        $sql_d = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql2";
                                    }else {
                                        $sql = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql ";
                                        $sql_d = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'  $date_sql2";
                                    }
                                
                                    $sql_device =  "select ga_deviceCategory,SUM(`ga_users`) as total from all_ga_data_platform_history where account_id = '$account_id' and 	profile_id = '$profile_id' and ga_deviceCategory !=''  $date_sql group by ga_deviceCategory";
                                    $sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id' group by yearmonth order by date asc" ; 
                        
                                    $rs_30_days = mysql_query($sql);
                                    $rs_all = mysql_query($sql_d);
                                    $rs_device_30_days = mysql_query($sql_device);
                                    $rs_year_session = mysql_query($sql_session);
                                }
                                
                                if(mysql_num_rows($rs_year_session)>0){   
                                    while($ga_365_session_detail = mysql_fetch_assoc($rs_year_session)){
                                        $year_month[] = $ga_365_session_detail['yearmonth'];
                                        $total_session[] = $ga_365_session_detail['totalsession'];
                                    }
                                }
                                if(mysql_num_rows($rs_all)>0){
                                    while($ga_all_days_detail = mysql_fetch_assoc($rs_all)){
                                        $day_pageview2[] = $ga_all_days_detail['ga_pageviews'];
                                        $day_date2[] = $ga_all_days_detail['date'];
                                        $day_session2[] = $ga_all_days_detail['ga_sessions'];
                                    }
                                }
                                if(mysql_num_rows($rs_30_days)>0){
                                    while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days)){
                                        $day_pageview[] = $ga_30_days_detail['ga_pageviews'];
                                        $day_date[] = $ga_30_days_detail['date'];
                                        $day_session[] = $ga_30_days_detail['ga_sessions'];
                                        
                                        $total_count += $ga_30_days_detail['ga_newUsers'];
                                        $total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
                                        $total_ga_visits += $ga_30_days_detail['ga_visits'];
                                        $total_ga_sessions += $ga_30_days_detail['ga_sessions'];
                                        $total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
                                        $total_ga_avgSessionDuration+= $ga_30_days_detail['ga_avgSessionDuration'] ;
                                    }
                                    $avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
                                    $avg_ga_pageviews_day = $total_ga_pageviews/$total_ga_visits ;
                                    $avg_ga_avgSessionDuration = $total_ga_avgSessionDuration/mysql_num_rows($rs_30_days);
                                    $avg_ga_avgSessionDuration_h_i_s = gmdate("H:i:s",$avg_ga_avgSessionDuration);
                                }
                                if(mysql_num_rows($rs_device_30_days)>0){   
                                    while($ga_30_days_device_detail = mysql_fetch_assoc($rs_device_30_days)){
                                        $device_name[] = $ga_30_days_device_detail['ga_deviceCategory'];
                                        $total_device_count[] = $ga_30_days_device_detail['total'];
                                        $total_val+= $ga_30_days_device_detail['total'];
                                    }
                                }
                             }
                             
                        }else{
                            $sql = "select * from ga_data_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' ";
                           $sql_d = "select * from ga_data_365_days where account_id = '$account_id' and 	profile_id = '$profile_id'";
                            $sql_device =  "select ga_deviceCategory,SUM(`ga_users`) as total from ga_data_platform_30_days where account_id = '$account_id' and 	profile_id = '$profile_id' and ga_deviceCategory !='' group by ga_deviceCategory";
                            $sql_session =    "SELECT concat(MONTHNAME(STR_TO_DATE(MONTH(date), '%m')),'-',YEAR(date)) as yearmonth, sum(`ga_sessions`) as      totalsession
                        FROM  `ga_data_365_days` where account_id = '$account_id' and 	profile_id = '$profile_id'
                        group by yearmonth order by date asc" ;
                        
                            $rs_30_days = mysql_query($sql) or die ( mysql_error() );	
                            $rs_all = mysql_query($sql_d) or die ( mysql_error() );
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
                            if(mysql_num_rows($rs_all)>0){
                                while($ga_all_days_detail = mysql_fetch_assoc($rs_all)){
                                    $day_pageview2[] = $ga_all_days_detail['ga_pageviews'];
                                    $day_date2[] = $ga_all_days_detail['date'];
                                    $day_session2[] = $ga_all_days_detail['ga_sessions'];
                                    
                        /*			print_r("<pre>");
                                    print_r($ga_all_days_detail) ; die;*/
                                }
                            }
                            if(mysql_num_rows($rs_30_days)>0){
                                while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days)){
                                    $day_pageview[] = $ga_30_days_detail['ga_pageviews'];
                                    $day_date[] = $ga_30_days_detail['date'];
                                    $day_session[] = $ga_30_days_detail['ga_sessions'];
                                    $total_count += $ga_30_days_detail['ga_newUsers'];
                                    $total_ga_bounce += $ga_30_days_detail['ga_bounceRate'];
                                    $total_ga_visits += $ga_30_days_detail['ga_visits'];
                                    $total_ga_sessions += $ga_30_days_detail['ga_sessions'];
                                    $total_ga_pageviews+= $ga_30_days_detail['ga_pageviews'];
                                    $total_ga_avgSessionDuration+= $ga_30_days_detail['ga_sessionDuration']/$ga_30_days_detail['ga_sessions'];
                                }
                                $avg_ga_bounce = round($total_ga_bounce/mysql_num_rows($rs_30_days));
                                $avg_ga_pageviews_day = $total_ga_pageviews/$total_ga_visits ;
                                $avg_ga_avgSessionDuration = $total_ga_avgSessionDuration/mysql_num_rows($rs_30_days);
                                $avg_ga_avgSessionDuration_h_i_s = gmdate("H:i:s",$avg_ga_avgSessionDuration);
                            }
                            if(mysql_num_rows($rs_device_30_days)>0){   
                                while($ga_30_days_device_detail = mysql_fetch_assoc($rs_device_30_days)){
                                    $device_name[] = $ga_30_days_device_detail['ga_deviceCategory'];
                                    $total_device_count[] = $ga_30_days_device_detail['total'];
                                    $total_val+= $ga_30_days_device_detail['total'];
                                }
                            }
                        }
                        
                        ?>
                        
                        <style>
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
                        </style>
                        <?php include('piechart.php');?>
                        <div id="main_container">
                            <div class="piechart"> 
                                <div class="icons content1"></div>
                                <div id="TotalVisits" class="chart_holder"></div>
                                <h1><?php $ans = $total_ga_sessions ; $ans2 = number_format($ans); echo $ans2; ?></h1>
                                <h6><span class="TotalVisitors" title="The total number of people <br />who have been to the site.">Total Visitors</span></h6>
                            </div>
                            <div class="piechart"> 
                                <div class="icons content2"></div>
                                <div id="PageViews" class="chart_holder"></div>
                                <h1><?php $total_ga_pageviews; $total_views = number_format($total_ga_pageviews); //echo $total_views; ?><?php echo empty($total_views) ? '0' : $total_views; ?></h1>
                                <h6><span class="PageViews" title="The number of web pages <br />viewed within your site.">Page Views</span></h6>
                            </div>
                            <div class="piechart"> 
                                <div class="icons content3"></div>
                                <div id="VisitorsChart" class="chart_holder"></div>
                                <h1><?php $total_count; $total_c = number_format($total_count); //echo $total_c; ?><?php echo empty($total_c) ? '0' : $total_c; ?></h1>
                                <h6><span class="NewVisitors" title="A visitor that has not been <br />to your website before.">New Visitors</span></h6>
                            </div>
                            <div class="piechart"> 
                                <div class="icons content4"></div>
                                <div id="BounceRateChart" class="chart_holder"></div>
                                <h1><?php //echo $avg_ga_bounce.'%';?><?php echo empty($avg_ga_bounce) ? '0.%' : $avg_ga_bounce.'%'; ?></h1>
                                <h6><span class="BounceRate" title="The percentage of people who leave the <br />site from the same page they arrived on.">Bounce Rate</span></h6>
                            </div>
                            <div class="piechart"> 
                                <div class="icons content5"></div>
                                <div id="AvePageViews" class="chart_holder"></div>
                                <h1><?php echo round($avg_ga_pageviews_day, 2);?></h1>
                                <h6><span class="AvgPagesViewed" title="The average number of pages a <br />visitors views per session.">Avg. Pages Viewed</span></h6>
                            </div>
                            <div class="piechart"> 
                                <div class="icons content6"></div>
                                <div id="AveTime" class="chart_holder"></div>
                                <h1>
                                <?php 
                                
                                    $str = $avg_ga_avgSessionDuration_h_i_s;
                                    
                                    list($hour, $minute, $second) = explode(":", $str);
                                    if($minute == 00 || $minute == '' && $second == 00 || $second == ''){
                                        echo '00:00';
                                    }else{
                                        if($hour != 00){
                                            echo $hour.':'.$minute.':'.$second;
                                        } else {
                                            echo $minute.':'.$second;
                                        }
                                    }
                                        
                                ?>
                                </h1>
                                <h6><span class="AvgTime" title="The average time a users spend<br /> on your website per session.">Avg. Time (min)</span></h6>
                            </div>
                        
                        
                        	<div style="clear:both;"></div>
                        
							<?php include('stockchart_icon_debug.php'); ?>
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
                                    <div class="icon_dev img1" /></div>
                                    <div id="desktop" class="chart_holder2"></div>
                                    <h1><?php echo round($total_device_count[0]*100/$total_val).'%<br/>'; ?></h1>
                                    <h6 class="device_name">Desktop</h6>
                                </div>
                                <div class="piechart2">
                                    <div class="icon_dev img2" /></div>
                                    <div id="tablet" class="chart_holder2"></div>
                                    <h1><?php echo round($total_device_count[2]*100/$total_val).'%<br/>'; ?></h1>
                                    <h6 class="device_name">Tablet</h6>
                                </div>
                                <div class="piechart2"> 
                                    <div class="icon_dev img3" /></div>
                                    <div id="mobile" class="chart_holder2"></div>
                                    <h1><?php echo round($total_device_count[1]*100/$total_val).'%<br/>'; ?></h1>
                                    <h6 class="device_name">Mobile</h6>
                                </div>
                            </div>
                     	</div> 
                 	</section>
              	</div>
           	</section>
     	</div>
   	</section>
</div>
                
                            
    

</body>
</html>