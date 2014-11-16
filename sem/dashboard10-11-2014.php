<?php
include("include/connection.php");
include("include/common_function.php");
	$client_id = $_GET["id"];
	$sql_client = "select distinct account_id , profile_id , client_name  from client where client_id = '$client_id' and  account_id!='' and profile_id!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 ){
		$client_detail = mysql_fetch_assoc($rs_client);
		$account_id = $client_detail['account_id'];
		$profile_id = $client_detail['profile_id'];
		$client_name =  $client_detail['client_name'];
	}
	 $campaign_id_link = array();
	
	$sql_camp_link = "select * from group_campaign_link where  client_id = '$client_id' and campaign_type = '4' ";
 	$rs_campaign_new_link = mysql_query($sql_camp_link) or die ( mysql_error() );
 
	if(mysql_num_rows($rs_campaign_new_link)>0){
		while($row_camp_link_new = mysql_fetch_assoc($rs_campaign_new_link)){
			$campaign_id_link[] = $row_camp_link_new['campaign_id'];
		}
 	}
	$sql_camp = '';
 	if(!empty($campaign_id_link)){
		$campaign_id_link = implode(",",$campaign_id_link); 
		if($campaign_id_link!=""){
			$campaign_id = $campaign_id_link;
		}
 	}	
 
 if($campaign_id==""){
	include('error_page.html');//die("Please contact admin to set SEM campaign-group for the client $client_name"); 
	die();
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>
<?php include('head_include.php');?>
<script type="text/javascript">AmCharts.themes.none = {};</script>
<script type="text/javascript">
$(document).mouseup(function (e){
   var container = $("#filter-form");
   if (!container.is(e.target) && container.has(e.target).length === 0){
	   $('#filter-form').removeClass('item-show');
		$('#filter-form').addClass('item-hide');
   }
});

function submit_form(account_id)
{
	var str = "";	
	str = "account_id="+account_id;
	var url = "ajax_property_db.php";	
	$("#img").show(); 
	var request = 
		$.ajax({
			url: url,
			type: "POST",
			data: str
		});
		request.done(function(msg) {
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
  
<script>
$(document).ready(function() {
	// Tooltip above and centered, this is the default setting
	$('.Impressions').jBox('Tooltip');
	$('.Clicks').jBox('Tooltip');
	$('.Events').jBox('Tooltip');
	$('.Calls').jBox('Tooltip');
	$('.WebTraffic').jBox('Tooltip');
});
</script>
<style>
	
	.filter-form{ width:365px;}
	#custom_drop_form{ width:352px;}
	.menu_container{ position:absolute; width:220px; margin: -26px 0 0 165px; background:#FFFFFF; z-index:1; border:1px solid #d3d3d3; display:none; padding-top:5px;}
	.option{ width:265px; margin: 15px 0 18px 88px; position:relative;}
	.option p{ font:bold 12px/1 Arial, Helvetica, sans-serif; width:76px; display:inline;}
	h2#nav { margin-left:10px; border-radius:2px; width: 186px; color:#000000; line-height: 25px; font-size: 14px; padding: 5px 5px 5px 10px; cursor: pointer; border:1px solid #d3d3d3; font:12px/1 Arial, Helvetica, sans-serif; display:inline-block; text-transform:uppercase;}
	ol.select { display: none; margin:5px 0 0 5px; width:200px;}
	ol.select > li {line-height: 20px; font-size: 12px; padding: 2px 4px; cursor: pointer; list-style:none; }
	ol.select > li a{ display:block; padding:0 5px; width:200px;}
	ol.select > li:hover, ol.select > li.active { }
	ol.select > li a:hover, ol.select > li a.ctive{ color:#FFFFFF !important; display:block; width:200px; background: #1e86e3; border-radius:2px;}
	#datepickerdivfrom, #datepickerdivto{font-size:9px; width:180px; float:left; position:relative;}
	#datepickerdivfrom label, #datepickerdivto label{ position:absolute; top:-13px; left:0; font:bold 10px/1 Arial, Helvetica, sans-serif; width:69px;}
	#date_picker_holder{width:360px; float:right; display:none; padding:20px 0 15px;}
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default,.ui-datepicker th {font-size:9px!important;}
	.activeClass{ background: #1e86e3; border-radius:2px; color:#ffffff !important}
	a:active.activeClassactive, a:hover.activeClassactive, a.activeClass{ color:#FFFFF !important;}
	
	.piechart h2, .piechart h6{ text-align:center; padding-right:0; font-size:32px; line-height:44.8px;}
	.piechart{ width:20%; float:left; position:relative; }
	.chart_holder{ width: 100%; height: 150px; margin:0 auto;  }
	.piechart > h2 { margin:17px 0;}
	/*#ImpressionsChart{ background:url(icons/impressions.png) center center no-repeat;}
	#ClicksChart{ background:url(icons/clicks.png) center center no-repeat;}
	#EventsChart{ background:url(icons/events.png) center center no-repeat;}
	#CallsChart{ background:url(icons/calls.png) center center no-repeat;}
	#RatiosChart{ background:url(icons/customer-engagement.png) center center no-repeat;}
	*/span.ImpressionsChart:hover, span.Clicks:hover, span.Events:hover, span.Calls:hover, span.CustomerEngagement:hover{ cursor:help;}
	
	h6.device_name{ text-transform:capitalize;}
	#PieChartContainer{ width:330px; float:right;}
	.piechart2{ width:33.3%; float:left; position:relative; }
	.piechart2 h1, .piechart2 h3, .piechart2 h6{ text-align:center; padding-right:0;}
	.chart_holder2{ width: 100%; height: 150px; margin:0 auto;  }
	/*.frm_cont_top > select{ font:11px/12px Verdana, Arial, sans-serif; }
	.frm_cont_top option{ margin:0.3em 0.5em; padding:2px 0 2px 2px !important; color:#1e86e3;}	*/
	.icons{
		width:42px;
		height:42px;
		position: absolute;
		left: 42%;
		top: 19%;
		background:url(icons/sem_icons.png);
	}
	
	.content1{}
	.content2{background-position: 0 -52px;}
	.content3{background-position: 0 146px;}
	.content4{background-position: 0 94px;}
	.content5{background-position: 0 78px;}
	.content6{background-position: 0 45px;}	
	
	#main_container{ width:1200px; margin:0 auto;}
	@media only screen and (min-device-width:1280px) and (max-device-width:1366px){
		#main_container{ width:920px!important;}
		.icons{
			width:42px;
			height:42px;
			position: absolute;
			left: 39%;
			top: 19%;
			background:url(icons/sem_icons.png);
		}
		
		.content1{}
		.content2{background-position: 0 -52px;}
		.content3{background-position: 0 146px;}
		.content4{background-position: 0 94px;}
		.content5{background-position: 0 78px;}
		.content6{background-position: 0 45px;}	
	}
	
	@media only screen and (min-device-width:800px) and (max-device-width:1500px){
		#main_container{ width:1080px;}
		.icons{
			width:42px;
			height:42px;
			position: absolute;
			left: 40%;
			top: 19%;
			background:url(icons/sem_icons.png);
		}
		
		.content1{}
		.content2{background-position: 0 -52px;}
		.content3{background-position: 0 146px;}
		.content4{background-position: 0 94px;}
		.content5{background-position: 0 78px;}
		.content6{background-position: 0 45px;}			
		
	}
.arrow-down1 {
	width: 0; 
	height: 0; 
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #1e85e3;
	position: absolute;
    right: 21px;
    top: 7px;	
}

.bg-white{position: relative;}

.arrow-down2 {
	width: 0; 
	height: 0; 
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #1e85e3;
	position: absolute;
    right: 7px;
    top: 13px;	
}
h6 p:hover{ cursor:help;}
.amChartsPeriodSelector{ display:none;}
#show-filter-form{ font-size:16px !important; line-height:22.4px !important;}
</style>

</head>

<body class="hybrid" style="overflow-x:hidden;">
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
                <a href="javascript:void(0)" id="show-filter-form">Filters <div class="arrow-down1"></div></a>
            </div>
            <div class="line"></div>
        </div>
            
        <div id="filter-form" class="filter-form item-hide">
            
        <form method="post">
            <input type="hidden" value="<?php echo $account_id;?>" name="accountSelector" /> 
	<?php
    
    $firstAccountId = $account_id;
        
         $sql_check_account = 
            "
            SELECT * 
            FROM  `ga_property` 
            where 
            account_id = '$firstAccountId' and profile_id = '$profile_id' 
            ";
    ?>
    <input type="hidden" value="<?php echo $profile_id;?>" name="webproperty-dd" />
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
                                                
                                               
        <div class="frm_buttons">        
            <input class="active_btn" type="submit" name="submit" value="Apply Filter"> 
            <input class="default_btn" type="button" value="Reset to Default" onClick="window.location.href=window.location.href">
        </div>
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
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$date_sql = "and date(ga.date) = '$today_date' ";
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$date_sql = "and date(ga.date) = '$yesterday_date' ";
		}else if($type=="last_week")
		{
			$date_sql = " and ga.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY
					 AND ga.date < curdate() - INTERVAL DAYOFWEEK(curdate())- 2 DAY	";
		}else if($type=="last_month")
		{	
			$date_sql = " and YEAR(ga.date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(ga.date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
		}else if($type=="last_3_months")
		{
			$date_sql = " and date(ga.date ) >= now()-interval 3 month	";
		}else if($type=="last_6_months")
		{
			$date_sql = " and date(ga.date ) >= now()-interval 6 month	";
		}else if($type=="last_year")
		{
			$date_sql = " and  ga.date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)		";
		}else if($type=="date_range")
		{
			$from_date = $_POST["from"];
			$to_date = $_POST["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			$date_sql = " and  ga.date between '$from_date' AND '$to_date'		";
		}
	}
	 	 $account_id = $_POST['accountSelector'];
		 $profile_id = $_POST['webproperty-dd'];
		 if($campaign_id!="")
		 {
		   if($date_sql==""){
  $sql =" select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents, 0 as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_30_days ga left join campaign_event_30_day gaw on ga.date = gaw.date and gaw.adwordsCampaignID in($campaign_id) and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  and ga.`adwordsCampaignID` in($campaign_id) group by ga.date) gaf  UNION ALL  
	select date(c.date) as date, 0 as impressions, 0 as adClicks, 0 as CTR, 0 as totalEvents, count(*) as total_call from call_log c where c.client_id = '$client_id' and date(c.date ) >= now()-interval 1 month group by date order by date";
		 
			 }
			  else { 
			 
       $sql =" select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents, 0 as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_history ga left join campaign_event_history gaw on ga.date = gaw.date and gaw.`adwordsCampaignID` in($campaign_id) and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  and ga.adwordsCampaignID in($campaign_id) $date_sql group by ga.date) gaf UNION ALL  
	select date(ga.date) as date, 0 as impressions, 0 as adClicks, 0 as CTR, 0 as totalEvents, count(*) as total_call from call_log ga where ga.client_id = '$client_id' $date_sql group by date order by date    ";
			 }
		 
		$rs_30_days = mysql_query($sql);
		if(mysql_num_rows($rs_30_days)>0){
			 $sum_impression = '';
			 $sum_adClicks = '';
			 $sum_TotalEvent = '';
			 $sum_total_call = '';
			 $sum_call_click_ratio = '';
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days)){
				$date[] = $ga_30_days_detail['date'];
				$impressions[] = $ga_30_days_detail['impressions'];
				$adClicks[] = $ga_30_days_detail['adClicks'];
				$CTR[] = $ga_30_days_detail['CTR'];
				$TotalEvent[] = $ga_30_days_detail['totalEvents'];
				$total_call[] = $ga_30_days_detail['total_call']; 
				$call_click_ratio[] = number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
				
				 $sum_impression += $ga_30_days_detail['impressions'];
				 $sum_adClicks += $ga_30_days_detail['adClicks'];
				 $sum_TotalEvent += $ga_30_days_detail['totalEvents'];
				 $sum_total_call+= $ga_30_days_detail['total_call'];
				 
				 $sum_call_click_ratio += number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
			}
			$sum_call_click_ratio = $sum_call_click_ratio / mysql_num_rows($rs_30_days);
			 }
		 }
	
else if($date_sql!="" and $campaign_id==""){
		  $sql = "select gaw.date as date, ifnull(sum(gaw.impressions),0) as impressions, ifnull(sum(gaw.adClicks),0) as adClicks, sum(gaw.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents, ifnull(sum(ca.total_call),0) as total_call from
		  (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(ga.totalEvents),0) as totalEvents  from ga_adword_event_data_history ga  where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  and ga.`adwordsCampaignID` in($campaign_id) and gaw.adwordsCampaignID in($campaign_id)  $date_sql group by ga.date) gaw 
		  left join (select c.date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by c.date, c.client_id) ca on gaw.date = date(ca.date) group by gaw.date order by gaw.date";
		 
	     	$rs_30_days = mysql_query($sql) or die ( mysql_error() );
		
		mysql_num_rows($rs_30_days);
		if(mysql_num_rows($rs_30_days)>0){
			 $sum_impression = '';
			 $sum_adClicks = '';
			 $sum_TotalEvent = '';
			 $sum_total_call = '';
			 $sum_call_click_ratio = '';
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days))
			{
				$date[] = $ga_30_days_detail['date'];
				$impressions[] = $ga_30_days_detail['impressions'];
				$adClicks[] = $ga_30_days_detail['adClicks'];
				$CTR[] = $ga_30_days_detail['CTR'];
				$TotalEvent[] = $ga_30_days_detail['totalEvents'];
				$total_call[] = $ga_30_days_detail['total_call']; 
				$call_click_ratio[] = number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
				
				$sum_impression += $ga_30_days_detail['impressions'];
				$sum_adClicks += $ga_30_days_detail['adClicks'];
				$sum_TotalEvent += $ga_30_days_detail['totalEvents'];
				$sum_total_call+= $ga_30_days_detail['total_call'];
				 
				$sum_call_click_ratio += number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
			}
			
			$sum_call_click_ratio = $sum_call_click_ratio / mysql_num_rows($rs_30_days);
			
			 }
			}else if($date_sql=="" and $campaign_id==""){
		 
		$sql = "select gaw.date as date, ifnull(sum(gaw.impressions),0) as impressions, ifnull(sum(gaw.adClicks),0) as adClicks, sum(gaw.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents, ifnull(sum(ca.total_call),0) as total_call from
		  (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(ga.totalEvents),0) as totalEvents  from ga_adword_event_data_30_days ga  where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  group by ga.date) gaw 
		  left join (select c.date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by c.date, c.client_id) ca on gaw.date = date(ca.date) group by gaw.date order by gaw.date" ;
	     $rs_30_days = mysql_query($sql) or die ( mysql_error()  );
		 
		if(mysql_num_rows($rs_30_days)>0)
		{
			$sum_impression = '';
			$sum_adClicks = '';
			$sum_TotalEvent = '';
			$sum_total_call = '';
			$sum_call_click_ratio = '';
			
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days))
			{
				$date[] = $ga_30_days_detail['date'];
				$impressions[] = $ga_30_days_detail['impressions'];
				$adClicks[] = $ga_30_days_detail['adClicks'];
				$CTR[] = $ga_30_days_detail['CTR'];
				$TotalEvent[] = $ga_30_days_detail['totalEvents'];
				$total_call[] = $ga_30_days_detail['total_call']; 
				$call_click_ratio[] = number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
				
				$sum_impression += $ga_30_days_detail['impressions'];
				$sum_adClicks += $ga_30_days_detail['adClicks'];
				$sum_TotalEvent += $ga_30_days_detail['totalEvents'];
				$sum_total_call+= $ga_30_days_detail['total_call'];
				$sum_call_click_ratio += number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
			}
			 $sum_call_click_ratio = $sum_call_click_ratio / mysql_num_rows($rs_30_days);
			 }
		}
	}
}

if(!isset($_POST["submit"])){
   $sql =" select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents, 0 as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_30_days ga left join campaign_event_30_day gaw on ga.date = gaw.date and gaw.adwordsCampaignID in($campaign_id) and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  and ga.`adwordsCampaignID` in($campaign_id) group by ga.date) gaf  UNION ALL  
	select date(c.date) as date, 0 as impressions, 0 as adClicks, 0 as CTR, 0 as totalEvents, count(*) as total_call from call_log c where c.client_id = '$client_id' and date(c.date ) >= now()-interval 1 month group by date order by date"; 

$sql_d = " select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents,ifnull(sum(ca.total_call),0) as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_history ga left join campaign_event_history gaw on ga.date = gaw.date and gaw.adwordsCampaignID in($campaign_id) and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  and ga.`adwordsCampaignID` in($campaign_id) group by ga.date) gaf left join (select date(c.date) as date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by date(c.date), c.client_id) ca on gaf.date = date(ca.date) group by gaf.date order by gaf.date    " ;
		  
		$rs_30_days = mysql_query($sql) or die ( mysql_error()  );
		$rs_all = mysql_query($sql_d) or die ( mysql_error() );
		
		if(mysql_num_rows($rs_30_days)>0)
		{
			//echo "Date : Impressions : Clicks : CTR : Total Event : Total call : Click to call Ratio"."</br>";
			 $sum_impression = '';
			 $sum_adClicks = '';
			 $sum_TotalEvent = '';
			 $sum_total_call = '';
			 $sum_call_click_ratio = '';
			while($ga_30_days_detail = mysql_fetch_assoc($rs_30_days))
			{
				$date[] = $ga_30_days_detail['date'];
				$impressions[] = $ga_30_days_detail['impressions'];
				$adClicks[] = $ga_30_days_detail['adClicks'];
				$CTR[] = $ga_30_days_detail['CTR'];
				$TotalEvent[] = $ga_30_days_detail['totalEvents'];
				$total_call[] = $ga_30_days_detail['total_call']; 
				$call_click_ratio[] = number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
				
				$sum_impression += $ga_30_days_detail['impressions'];
				$sum_adClicks += $ga_30_days_detail['adClicks'];
				$sum_TotalEvent += $ga_30_days_detail['totalEvents'];
				$sum_total_call+= $ga_30_days_detail['total_call'];
				 
				$sum_call_click_ratio += number_format((($ga_30_days_detail['total_call']/$ga_30_days_detail['adClicks'])*100),2);
			}
			//pr($date);
			$sum_call_click_ratio = $sum_call_click_ratio / mysql_num_rows($rs_30_days);
			 }
			 
			 
			 if(mysql_num_rows($rs_all)>0)
		{
			while($ga_history_detail = mysql_fetch_assoc($rs_all))
			{
				$date2[] = $ga_history_detail['date'];
				$impressions2[] = $ga_history_detail['impressions'];
				$adClicks2[] = $ga_history_detail['adClicks'];
				$TotalEvent2[] = $ga_history_detail['totalEvents'];
			} }
}
?>


<?php include('piechart_sem.php');?>

<div id="main_container">
<div class="piechart">
	<div class="icons content1"></div>
	<div id="ImpressionsChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_impression); ?></h2>
	<h6><p class="Impressions" title=" The number of times your ad has been shown.">Impressions</p></h6>
</div>
<div class="piechart"> 
	<div class="icons content2"></div>
	<div id="ClicksChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_adClicks); ?></h2>
	<h6><p class="Clicks" title="The number of click on your ads.">Clicks</p></h6>
</div>
<div class="piechart"> 
	<div class="icons content3"></div>
	<div id="EventsChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_TotalEvent); ?></h2>
	<h6><p class="Events" title="The amount of interactions users <br />had after arriving on your site.">Events</p></h6>
</div>
<div class="piechart"> 
	<div class="icons content4"></div>
	<div id="CallsChart" class="chart_holder"></div>
	<h2><?php if($sum_total_call == 0){ echo '0';}else{ echo $sum_total_call;} ?></h2>
	<h6><p class="Calls" title="The number of calls directly from your ads.">Calls</p></h6>
</div>
<div class="piechart"> 
	<div class="icons content6"></div>
	<div id="RatiosChart" class="chart_holder"></div>
	<h2><?php echo round($sum_TotalEvent / $sum_adClicks * 100).'%'; //echo round($sum_call_click_ratio,2).'%';?></h2>
	<h6><p class="WebTraffic" title="Percentage of Paid traffic from all site visits.">Web Traffic</p></h6>
</div>
<div style="clear:both;"></div>
<br />


<?php include('stockchart_sem.php'); ?>
<div style="clear:both;"></div>
<div id="StockChart" style="width: 100%; height: 500px; background-color: #FFFFFF;"></div>		
</div>
</div>

</body>
</html>