<?php
//error_reporting(0);
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

<style type="text/css">
.filter-form{width:365px}#custom_drop_form{width:352px}.menu_container{position:absolute;width:220px;margin:-26px 0 0 165px;background:#FFF;z-index:1;border:1px solid #d3d3d3;display:none;padding-top:5px}.option{width:265px;margin:15px 0 18px 88px;position:relative}.option p{font:700 12px/1 Arial,Helvetica,sans-serif;width:76px;display:inline}h2#nav{margin-left:10px;border-radius:2px;width:186px;color:#000;line-height:25px;padding:5px 5px 5px 10px;cursor:pointer;border:1px solid #d3d3d3;font:12px/1 Arial,Helvetica,sans-serif;display:inline-block;text-transform:uppercase}ol.select{display:none;margin:5px 0 0 5px;width:200px}ol.select>li{line-height:20px;font-size:12px;padding:2px 4px;cursor:pointer;list-style:none}ol.select>li a{display:block;padding:0 5px;width:200px}ol.select>li a.ctive,ol.select>li a:hover{color:#FFF!important;display:block;width:200px;background:#1e86e3;border-radius:2px}#datepickerdivfrom,#datepickerdivto{font-size:9px;width:180px;float:left;position:relative}#datepickerdivfrom label,#datepickerdivto label{position:absolute;top:-13px;left:0;font:700 10px/1 Arial,Helvetica,sans-serif;width:69px}#date_picker_holder{width:360px;float:right;display:none;padding:20px 0 15px}.ui-datepicker th,.ui-state-default,.ui-widget-content .ui-state-default,.ui-widget-header .ui-state-default{font-size:9px!important}.activeClass{background:#1e86e3;border-radius:2px;color:#fff!important}a.activeClass,a:active.activeClassactive,a:hover.activeClassactive{color:#FFFFF!important}.piechart h1,.piechart h6{text-align:center;padding-right:0}.piechart{width:16.6%;float:left;position:relative}.chart_holder{width:100%;height:150px;margin:0 auto}.icons{width:34px;height:34px;position:absolute;left:42%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}h6.device_name{text-transform:capitalize}#PieChartContainer{width:350px;float:right}.piechart2{width:115.5px;float:left;position:relative}.piechart2 h1,.piechart2 h3,.piechart2 h6{text-align:center;padding-right:0}.piechart2 .icon_dev{position:absolute;top:60px;left:41px;width:34px;height:34px;background:url(icons/devices.png)}.icon_dev.img2{background-position:0 78px}.icon_dev.img3{background-position:0 34px}.chart_holder2{width:100%;height:150px;margin:0 auto}#desktop{background-size:34px 34px}#main_container{max-width:1200px;margin:0 auto}#StockChart{width:92%;height:500px;margin:0 auto}

@media only screen and (min-device-width:1280px) and (max-device-width:1366px) {#main_container{width:920px}.icons{width:34px;height:34px;position:absolute;left:40%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}
}
span.AvgPagesViewed:hover,span.AvgTime:hover,span.BounceRate:hover,span.NewVisitors:hover,span.PageViews:hover,span.TotalVisitors:hover{cursor:help}.arrow-down1{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:21px;top:7px}.arrow-down2{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:7px;top:13px}.bg-white{position:relative}
.amChartsPeriodSelector{ display:none;}

#Trends{ max-width:1200px; margin:30px auto 15px;}
.dayoftheweek, .dayofthemonth{ width:50%; height:350px; float:left; position:relative;}

#SBMOTY, #SBDOTW{margin-top:60px;}

h6 span { background: url("header-bg.png") repeat scroll right center rgba(0, 0, 0, 0); display: block; position: absolute; right: -1px; top: 0; width: 62%;}
.btn_new { -moz-border-bottom-colors: none; -moz-border-left-colors: none; -moz-border-right-colors: none; -moz-border-top-colors: none; background-color: #f5f5f5; background-image: linear-gradient(to bottom, #ffffff, #e6e6e6); background-repeat: repeat-x; border-color: #cccccc #cccccc #b3b3b3; border-image: none; border-radius: 4px; border-style: solid; border-width: 1px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); color: #333333; cursor: pointer; display: inline-block; font-size: 14px; line-height: 20px; margin-bottom: 0; padding: 4px 12px; text-align: center; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle;}
.btn_new:hover, .btn_new:focus { color: #333333; text-decoration: none; transition: background-position 0.1s linear 0s;}
.btn_new{ font-size: 20px;}
#heat_map_container > div {
  padding-right: 22px;
  text-align: right;
}
.icon-clock {
  font-size: 20px;
  left: -21px;
  position: absolute;
  top: -1px;
}
.time{ position: relative;}
h6 p{ display: inline;}
iframe{ border:none;}
#heat-map { margin-left:0 !important; }
@media only screen and (min-device-width:1280px) and (max-device-width:1366px) {
	.cal-heatmap-container { width:98.5% !important; }
}
@media only screen and (min-width:1280px) and (max-width:1366px) {
	.cal-heatmap-container { width:98.5% !important; }
}
@media only screen and (min-width: 40.063em){
	.cal-heatmap-container { width:98.5% !important; }
	.hour { width:77% !important; }
	.dual { width:50%; }
	.year { width:81% !important; }
}
</style>
</style>
<link rel="stylesheet" href="StyleSheets/style.css">
<!--[if lt IE 8]><!-->
<link rel="stylesheet" href="StyleSheets/ie7/ie7.css">
<!--<![endif]-->
<?php include('head_include.php');?>
<script type="text/javascript" src="Scripts/d3.v3.min.js"></script>
<script type="text/javascript" src="Scripts/cal-heatmap.min.js"></script>
<link rel="stylesheet" href="StyleSheets/cal-heatmap.css" />
<script type="text/javascript">
AmCharts.themes.none = {};
</script>
<script>
$(document).ready(function() {
	// Tooltip above and centered, this is the default setting
	$('.SessionsbyHour').jBox('Tooltip');
	$('.SessionsbyWeek').jBox('Tooltip');
	$('.SessionsbyMonth').jBox('Tooltip');
	$('.SessionsbyYear').jBox('Tooltip');
});
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
                        
                       $total_count = ''; $total_ga_bounce = ''; $total_ga_visits = ''; $total_ga_pageviews = ''; $total_ga_avgSessionDuration = ''; $avg_ga_bounce = '';
                        $avg_ga_pageviews_day = ''; $avg_ga_avgSessionDuration = '';
                        
if(isset($_POST["submit"]))
{
	if(isset($_POST["type"]) and $_POST["type"]!="")
	{
		$type = $_POST["type"];
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$date_sql = " date(a.date) = '$today_date' ";
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$date_sql = " date(a.date) = '$yesterday_date' ";
		}else if($type=="last_week")
		{
			$date_sql = " a.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY AND a.date < curdate() - INTERVAL DAYOFWEEK(curdate())- 2 DAY	";
		}else if($type=="last_month")
		{	
			$date_sql = " YEAR(a.date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(a.date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
		}else if($type=="last_3_months")
		{
			$date_sql = "  date(a.date ) >= now()-interval 3 month		";
		}else if($type=="last_6_months")
		{
			$date_sql = "  date(a.date ) >= now()-interval 6 month		";
		}else if($type=="last_year")
		{
			$date_sql = " a.date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)		";
		}else if($type=="date_range")
		{
			$from_date = $_POST["from"];
			$to_date = $_POST["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			$date_sql = " a.date between '$from_date' AND '$to_date'		";
		}
	}
	$sql_hour = "SELECT a.`hour` as hour, sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id where 
  b.client_id = '$client_id' and $date_sql group by a.`hour` order by a.`hour` "; 
$sql_week = "SELECT DAYNAME(a.`date`) as day,sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by DAYNAME(a.`date`) ORDER BY FIELD(DAYNAME(a.date), 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
 
$sql_month = "SELECT MONTHNAME(a.`date`) as month,sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by MONTHNAME(a.`date`) order by a.`date` asc  ";

$sql_year =  "SELECT a.`date` as date , sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE year(a.`date`) = year(now()) and b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by a.`date` order by a.`date` asc  ";

 $sql_year_graph =  "SELECT sum(c.impressions) as impressions, sum(c.clicks) as clicks, sum(a.`event`) as event from ((SELECT a.date,a.adwordsCampaignID, sum(a.`totalEvents`) as `event` FROM `ga_event_category_data_365_days` a GROUP BY a.date,a.adwordsCampaignID) a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id inner join (SELECT c.date, c.adwordsCampaignID, sum(c.impressions) as impressions, sum(c.adClicks) as clicks from ga_adword_campaign_data_history c group by c.date, c.adwordsCampaignID) c on a.adwordsCampaignID = c.adwordsCampaignID and a.date = c.date) WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql";
	
	
}else{
   $sql_hour = "SELECT a.`hour` as hour, sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id where 
  b.client_id = '$client_id' and date(a.date )>= now()-interval 1 month 
  group by a.`hour` order by a.`hour`" ;
   
$sql_week = "SELECT DAYNAME(a.`date`) as day,sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and date(a.date )>= now()-interval 1 month
group by DAYNAME(a.`date`) ORDER BY FIELD(DAYNAME(date), 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
 
$sql_month = "SELECT MONTHNAME(a.`date`) as month,sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and date(a.date )>= now()-interval 12 month
group by MONTHNAME(`date`) order by a.`date` asc  ";

$sql_year =  "SELECT a.`date` as date , sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id'
group by a.`date` order by a.`date` asc  ";

 $sql_year_graph =  "SELECT sum(c.impressions) as impressions, sum(c.clicks) as clicks, sum(a.`event`) as event from ((SELECT a.date,a.adwordsCampaignID, sum(a.`totalEvents`) as `event` FROM `ga_event_category_data_365_days` a GROUP BY a.date,a.adwordsCampaignID) a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id inner join (SELECT c.date, c.adwordsCampaignID, sum(c.impressions) as impressions, sum(c.adClicks) as clicks from ga_adword_campaign_data_history c group by c.date, c.adwordsCampaignID) c on a.adwordsCampaignID = c.adwordsCampaignID and a.date = c.date) WHERE b.campaign_type = 4 and b.client_id = '$client_id' and date(c.date )>= now()-interval 12 month and date(a.date )>= now()-interval 12 month";

}
					    $rs_hour_data = mysql_query($sql_hour) or die ( mysql_error() );
                            $rs_week_data = mysql_query($sql_week) or die ( mysql_error() );    
                            $rs_month_data = mysql_query($sql_month) or die ( mysql_error() );
                            $rs_year_data = mysql_query($sql_year) or die ( mysql_error() );
                            $rs_year_graph_data = mysql_query($sql_year_graph) or die ( mysql_error() );    
                            
							
							
                            if(mysql_num_rows($rs_hour_data)>0){  
                                while($ga_hour_data = mysql_fetch_assoc($rs_hour_data)){
                                 // $hour[] = $ga_hour_data['hour'];
                                //  $hour_event[] = $ga_hour_data['event'];
								  
								  // change address of array 
								 $hour[$ga_hour_data['hour']] = $ga_hour_data['hour'];
                                 $hour_event[$ga_hour_data['hour']] = $ga_hour_data['event'];
								  
                                }
                            }
							
							
							// <===== start added data for the empty hours & event =====>
							for($h=0;$h<24;$h++)
							{
								$h = sprintf("%02s",$h);
								if(!isset($hour[$h]))
								{
									$hour[$h] = sprintf("%02s",$h);
								}else{
									$hour[$h] = $hour[$h];
								}
							}
							
							for($h=0;$h<24;$h++)
							{
								$h = sprintf("%02s",$h);
								if(!isset($hour_event[$h])  )
								{
									$hour_event[$h] = 0;
								}else{
									$hour_event[$h] = $hour_event[$h];
								}
							}
							
							for($h=0;$h<24;$h++)
							{	
							    $h = sprintf("%02s",$h);							
								$hour[$h] = sprintf("%02s",$h);	
							}
							
							for($h=0;$h<24;$h++)
							{
								$h = sprintf("%02s",$h);
								$hour_event[$h] = $hour_event[$h];	
							}
							
							$hour_temp = array();
							$hour_event_temp = array();
							for($i=0;$i<24;$i++)
							{
								$i = sprintf("%02s",$i);
								$hour_temp[] = $hour[$i];
								$hour_event_temp[] = $hour_event[$i];
							}
							
							$hour = array();
							$hour_event = array();
							$hour = $hour_temp;
							$hour_event = $hour_event_temp;
					
							//pr($hour_temp);
							//pr($hour_event_temp);	
						
						// <===== end added data for the empty hours & event =====>
	
							
                            
                            if(mysql_num_rows($rs_week_data)>0){  
                                while($ga_week_data = mysql_fetch_assoc($rs_week_data)){
                                 // $week_day[] = $ga_week_data['day'];
                                //  $week_event[] = $ga_week_data['event'];
								  
								  $week_day[$ga_week_data['day']] = $ga_week_data['day'];
                                  $week_event[$ga_week_data['day']] = $ga_week_data['event'];
								  
								  
                                }
                            }
							
							/*pr($week_day);
							pr($week_event);*/
							
							// start setting week day 
							
							$week_day_name = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
							
							foreach($week_day_name as $weekday_name)
							{
								 if(!isset($week_day[$weekday_name]))
								{
									$week_day[$weekday_name] = $weekday_name;
								}else{
									$week_day[$weekday_name] = $week_day[$weekday_name];
									
								}
							}
							
							foreach($week_day_name as $weekday_name)
							{
								 if(!isset($week_event[$weekday_name]))
								{
									$week_event[$weekday_name] = 0;
								}else{
									$week_event[$weekday_name] = $week_event[$weekday_name];
									
								}
							}
							
							$week_day_temp = array();
							$week_event_temp = array();
							
							foreach($week_day_name as $weekday_name)
							{
								$week_day_temp[$weekday_name] = $week_day[$weekday_name];
								$week_event_temp[$weekday_name] = $week_event[$weekday_name];
							}
							
							
							
							$week_day = array();
							$week_event = array();
							$week_day = $week_day_temp;
							$week_event = $week_event_temp;
							
							
							
							
							/*pr($week_day);
							pr($week_event);*/
							
                            

                            
							if(mysql_num_rows($rs_month_data)>0){  
                                while($ga_month_data = mysql_fetch_assoc($rs_month_data)){
/*                                  $month_name[] = $ga_month_data['month'];
                                  $month_event[] = $ga_month_data['event'];*/ 
								  $month_name[$ga_month_data['month']] = $ga_month_data['month'];
                                  $month_event[$ga_month_data['month']] = $ga_month_data['event'];
                                }
                            }
							
$month_day_name = array();
$currentMonth = (int)date('m') +1 ;

//$currentMonth = date('F', mktime(0, 0, 0, $currentMonth + 1, 1));

for ($x = $currentMonth; $x <= $currentMonth + 12; $x++) {
    $month_day_name[] = date('F', mktime(0, 0, 0, $x, 1));
}
							
//	$month_day_name = array('January','February','March','April','May','June','July','August','September','October','November','December');
							
							foreach($month_day_name as $monthday_name)
							{
								 if(!isset($month_name[$monthday_name]))
								{
									$month_name[$monthday_name] = $monthday_name;
								}else{
									$month_name[$monthday_name] = $month_name[$monthday_name];
									
								}
							}
							
							foreach($month_day_name as $monthday_name)
							{
								 if(!isset($month_event[$monthday_name]))
								{
									$month_event[$monthday_name] = 0;
								}else{
									$month_event[$monthday_name] = $month_event[$monthday_name];
									
								}
							}
							
							$month_day_temp = array();
							$month_event_temp = array();
							
							foreach($month_day_name as $monthday_name)
							{
								$month_day_temp[$monthday_name] = $month_name[$monthday_name];
								$month_event_temp[$monthday_name] = $month_event[$monthday_name];
							}
							
							
							
							$month_name = array();
							$month_event = array();
							$month_name = $month_day_temp;
							$month_event = $month_event_temp;
							
							if(mysql_num_rows($rs_year_data)>0){  
                                while($ga_year_data = mysql_fetch_assoc($rs_year_data)){
                                  $date[] = $ga_year_data['date'];
                                  $year_event[] = $ga_year_data['event'];
                                }
                            }
                            

							
							$heat_arr = array();
							foreach ($date as $key => $value) {
								$n_value = strtotime($value);

								$heat_arr[] = "\"{$n_value}\":{$year_event[$key]}";
							}
							$final_heat = implode(",", $heat_arr);
                            
                            if(mysql_num_rows($rs_year_graph_data)>0){  
                                while($ga_year_graph_data = mysql_fetch_assoc($rs_year_graph_data)){
                                  $impression[] = $ga_year_graph_data['impressions'];
                                  $click[] = $ga_year_graph_data['clicks'];
                                  $event[] = $ga_year_graph_data['event'];
                                }
                            }
							
							//echo " Event by the year graph: "."</br>";
							//echo "IMPRESSION"." : "."CLICK"." : "."EVENT"."</br>" ;
								  
							//$i=0;
							//foreach ($impression as $impression_value) {
								//echo    $impression_value." : ".$click[$i]." : ".$event[$i]."</br>" ;
								//$i++;
							//}
                        ?>
                        <div style="clear:both;"></div>
                        <script type="text/javascript">
                        $( document ).ready(function() {
                        
                            // datas is an array of object
                            var datas = <?php echo '{'.$final_heat.'}'; ?>
                        
                            var parser = function(data) {
                                var stats = {};
                                for (var d in data) {
                                    stats[data[d].date] = data[d].value;
                                }
                                return stats;
                            };
                        
                            /* Parser will output the object
                            {
                                "946702811": 15,
                                "946702812": 25,
                                "946702813": 10
                            }*/
                        
                            var cal = new CalHeatMap();
                            cal.init({
                                itemSelector: "#heat-map",
                                itemName: ["event", "events"],
                                domain: "month",
                                subDomain: "day",
                                //data: "data.json",
                                data: datas,
                                //afterLoadData: parser,
                                cellSize: 20,
                                start: new Date(<?php echo date('Y'); ?>, 0, 1),
                                legend: [1, 2, 3, 4],
								legendColors: ["#ddecfc","#53a4f9"],
                                //legendColors: ["#e8f0fe", "#1c3aa9"],
                                tooltip: true,	
                                subDomainTextFormat: "%d",
                                range: 10,
                                displayLegend: true,
                                nextSelector: "#domainDynamicDimension-next",
                                previousSelector: "#domainDynamicDimension-previous",
                                legendVerticalPosition: "top"	
                            });
                        });
                        </script>
                        <?php  include('columnchart_trend.php');?>
                        <div id="Trends">
                            <!-- Events by hours -->
                            <div style="width: 100%; height: 240px; background-color: #FFFFFF; float:left; position:relative; padding-top:35px; clear:both; margin-bottom:115px;">
                                <h6 style="position:absolute; left:0; top:0; width:98%;"><p class="SessionsbyHour" title="Events per hour of the day. Please use the<br/>filter to select the date range for this data.">Events by Hour of the Day</p> <span style="width: 82% ! important; right: -9px ! important;">&nbsp;</span></h6>
                                <p style="text-align: right; margin-bottom: 5px ! important; margin-right: 17px;"><span class="time"><span class="icon-clock"></span>&nbsp;Australian Eastern Time Zone (UTC+10:00)</span></p>
                                <div id="SBHOTD" style="width:100%; height:240px; margin-top:25px;"></div>
                            </div>
                            <!-- end of Events by hours -->	
                            <div class="dayoftheweek">
                                <h6 style="position:absolute; left:0; top:0; width:97%;"><p class="SessionsbyWeek" title="Events per day of the week. Please use the<br/>filter to select the date range for this data.">Events by Day of the Week</p>  <span>&nbsp;</span></h6>
                                <div id="SBDOTW" style="width:100%; height:262px;"></div>
                            </div>
                            <div class="dayofthemonth">
                                <h6 style="position:absolute; left:0; top:0; width:97%;"><p class="SessionsbyMonth" title="Events per month of the year. Use the monthly chart to see<br/>seasonal trends. Data is on a rolling 12 month scale.">Events by Month of the Year</p>  <span>&nbsp;</span></h6>
                                <div id="SBMOTY" style="width:100%; height:262px;"></div>
                            </div>
                            <div style="clear:both"></div>
                            <div id="heat_map_container" style="position:relative; padding-top:50px;">
                                <h6 style="position:absolute; left:0; top:0; width:97%;"><p class="SessionsbyYear" title="The yearly chart shows hot spots and gaps in your events throughout the year.">Events by Year</p>  <span style="right:-12px !important; width:87% !important;">&nbsp;</span></h6>
                                <div>
                                    <button class="btn_new" id="domainDynamicDimension-previous">
                                        <span class="icon-arrow-left"></span>
                                    </button>
                                    <button class="btn_new" id="domainDynamicDimension-next">
                                        <span class="icon-arrow-right"></span>
                                    </button>
                                </div>	
                                <div id="heat-map" style="padding:0; position: relative; width: 99%; position:relative; margin:0 20px;"></div>
                            </div>

                            <?php  //include('funnel_trend.php');?>		
                            <!--<div id="chartfunnel"></div>-->
                            <!--<div style="clear:both">
                            	<iframe src="final_funnel_trend.php?id=<?php //echo $client_id; ?>" width="100%" height="480"></iframe>
                            </div>-->                            
                        </div> 
                                               



                	</section>
                </div>
       		</section>
     	</div>
   	</section>
</div>
<script>
    (function(f,b,g){
        var d=g.prototype.open,a=g.prototype.send,c;
        f.hj=f.hj||function(){(f.hj.q=f.hj.q||[]).push(arguments)};
        f._hjSettings={hjid:2939};
        if(typeof b.addEventListener!=="undefined"){b.addEventListener("DOMContentLoaded",function(){f.hj.documentHtml=b.documentElement.outerHTML})}
        c=b.createElement("script");c.async=1;c.src="//static.hotjar.com/insights.js";b.getElementsByTagName("head")[0].appendChild(c);f.hj.xo=g.prototype.open;f.hj.xs=g.prototype.send;
        if(!f._hjPlayback){
            f.hj.xo=g.prototype.open;f.hj.xs=g.prototype.send;
            g.prototype.open=function(l,j,m,h,k){this._u=j;f.hj.xo.call(this,l,j,m,h,k)};
            g.prototype.send=function(e){var j=this,i=j._u.indexOf("insights.hotjar.com")===-1;if(i){function h(){if(j.readyState===4){f.hj("_xhr",j._u,j.status,j.response)}}if(this.addEventListener){this.addEventListener("readystatechange",h,false)}else{this.attachEvent("onreadystatechange",h)}}f.hj.xs.call(this,e)}
        }
    })(window,document,window.XMLHttpRequest);
</script>
</body>
</html>