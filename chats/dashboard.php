<?php

include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];
	$sql_client = "select distinct account_id from client where client_id = '$target_number' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		 $account_id = $client_detail['account_id'];
	}
	
	$sql_chat_company = "select distinct companyKey,city,state,country from chat_company_info where googleAnalyticsAccount LIKE '%$account_id%' ";
	$rs_chat_company = mysql_query($sql_chat_company) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_chat_company) > 0 )
	{
		$chat_company_detail = mysql_fetch_assoc($rs_chat_company);
		//pr($client_detail);
	    $companyKey = $chat_company_detail['companyKey'];
		$city = $chat_company_detail['city'];
		$state = $chat_company_detail['state'];
		$country = $chat_company_detail['country'];
	}
	else
	{
		include('error_page.html');	
		die;	
		//echo "Please set apex chat company for this client" ; die;
	}

$target_number_sql = " and  companyKey in ('$companyKey')  ";
$sql_campaign_id = '';

if($_GET["search"])
{
	if(isset($_GET["type"]) and $_GET["type"]!="")
	{
		$type = $_GET["type"];
		// today day
		if($type=="today"){
			$today_date = date( "Y-m-d" );
			$where = "where date(createdOn) = '$today_date' ";
		}else if($type=="yesterday"){
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = "where date(createdOn) = '$yesterday_date' ";
		}else if($type=="last_week"){
			$where = "WHERE createdOn >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY
				 AND createdOn < curdate() - INTERVAL DAYOFWEEK(curdate()) -2  DAY ";
		
/*		$where = "WHERE 
WEEK (createdOn,1) = WEEK(curdate(),1) - 1 AND YEAR(createdOn)= YEAR(curdate())";*/
					 
					 
		}else if($type=="last_month"){		 
           $where = "	WHERE YEAR(createdOn) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(createdOn) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) " ;
		}else if($type=="last_3_months"){
             $where = "WHERE date(createdOn ) >= now()-interval 3 month " ;
		}else if($type=="last_6_months"){
			$where = "WHERE date(createdOn ) >= now()-interval 6 month" ;	
		}else if($type=="last_year"){
			$where = "where createdOn >= DATE_SUB(NOW(),INTERVAL 1 YEAR)" ;
		}else if($type=="date_range"){
			$from_date = $_GET["from"];
			$to_date = $_GET["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));

            $where = "where createdOn between '$from_date' AND '$to_date' " ;			
		}
		}else{
			$target_number_sql = "" ;
			$where = "where companyKey in ('$companyKey')"; 
		}
}else{
	       	$target_number_sql = "";
			$where = "where companyKey in ('$companyKey')"; 
}

 $sql = "select * from chat_lead_info ".$where." ".$target_number_sql." order by date(createdOn) desc";

 if(isset($_GET["type"]) and $_GET["type"]!="") {
 $sql_summary = "select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." "."union all select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." and `leadType`='1' union all select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." "." and `leadType`!='1'" ; }
 else { 
 $sql_summary = "select count(distinct `id`) as prospect from chat_lead_info ".$where." and date(createdOn) >= now()-interval 1 month ".$target_number_sql." "."union all select count(distinct `id`) as prospect from chat_lead_info ".$where." and date(createdOn) >= now()-interval 1 month ".$target_number_sql." and `leadType`='1' union all select count(distinct `id`) as prospect from chat_lead_info ".$where." and date(createdOn) >= now()-interval 1 month ".$target_number_sql." "." and `leadType`!='1'" ;
 } 
 
 $sql_line_summary = "select a.date as date, ifnull(a.prospect,0) as prospect, ifnull(b.leads,0) as leads, ifnull(c.non_bilable,0) as non_bilable from (SELECT date(`createdOn`) as date, count(*) as prospect FROM `chat_lead_info` $where $target_number_sql group by date(`createdOn`)) a left outer join (SELECT date(`createdOn`) as date, count(*) as leads FROM `chat_lead_info` $where $target_number_sql and `leadType`='1' group by date(`createdOn`)) b on a.date = b.date left outer join (SELECT date(`createdOn`) as date, count(*) as non_bilable FROM `chat_lead_info` $where $target_number_sql and `leadType`!='1' group by date(`createdOn`)) c on b.date = c.date ";
 
 $target_number_sql_all = "";
 $where_all = "where companyKey in ('$companyKey')"; 
 
 $sql_line_summary_all = "select a.date as date, ifnull(a.prospect,0) as prospect, ifnull(b.leads,0) as leads, ifnull(c.non_bilable,0) as non_bilable from (SELECT date(`createdOn`) as date, count(*) as prospect FROM `chat_lead_info` $where_all $target_number_sql_all group by date(`createdOn`)) a left outer join (SELECT date(`createdOn`) as date, count(*) as leads FROM `chat_lead_info` $where_all $target_number_sql_all and `leadType`='1' group by date(`createdOn`)) b on a.date = b.date left outer join (SELECT date(`createdOn`) as date, count(*) as non_bilable FROM `chat_lead_info` $where_all $target_number_sql_all and `leadType`!='1' group by date(`createdOn`)) c on b.date = c.date "; 
 
 
$rs_line_summary_all = mysql_query($sql_line_summary_all) or die ( mysql_error() );	
if(mysql_num_rows($rs_line_summary_all) > 0 ){
	$i = 0;
	while($line_summary_all = mysql_fetch_assoc($rs_line_summary_all)){
		  $date_line2[] = $line_summary_all['date'];
		  $prospect_line2[] = $line_summary_all['prospect'];
		  $leads_line2[] = $line_summary_all['leads'];
		  $non_bilable_line2[] =  $line_summary_all['non_bilable'];
	}
}
 
 //echo $sql_line_summary_all.'<br/><br/>';
 //echo $sql_line_summary;
 
 $rs_line_summary = mysql_query($sql_line_summary) or die ( mysql_error() );	
 if(mysql_num_rows($rs_line_summary) > 0 )
	{
		$i = 0;
		while($line_summary = mysql_fetch_assoc($rs_line_summary))
        {
		  $date_line[] = $line_summary['date'];
		  $prospect_line[] = $line_summary['prospect'];
		  $leads_line[] = $line_summary['leads'];
		  $non_bilable_line[] =  $line_summary['non_bilable'];
		}
	}

$rs_lead_info = mysql_query($sql) or die ( mysql_error() );	

$rs_lead_summary = mysql_query($sql_summary) or die ( mysql_error() );	
		if(mysql_num_rows($rs_lead_summary) > 0 )
		{
	   		while($lead_summary = mysql_fetch_assoc($rs_lead_summary)){
          		$lead_summary_detail[] = $lead_summary['prospect'];
			}
		}
		   $prospect = $lead_summary_detail[0];
		   $leads = $lead_summary_detail[1];
		   $non_bilable_leads = $lead_summary_detail[2];
		   
		   $lead_perc = floor(($leads/$prospect)*100);

          //echo "prospect = ".$prospect."</br>";
		  //echo "leads = ".$leads."</br>";
		  //echo "non_bilable = ".$non_bilable_leads."</br>";
		  //echo "lead_perc =".$lead_perc."</br>";
		  
		  $prospect_f = $lead_perc + $leads;
		  
		  //Prospects = non-Billable + billable (Leads)

	if(mysql_num_rows($rs_lead_info) > 0 )
	{
		$i = 0;
		while($lead_detail = mysql_fetch_assoc($rs_lead_info))
        {
          $date[] = $lead_detail['createdOn'];
		  $chat_start_dtm[] = $lead_detail['chat_start_dtm'];
		  $chat_duration[] = $lead_detail['chat_duration'];
		  $time = explode(":", $lead_detail['chat_duration']);
		  $location[] = $lead_detail['location'];
		  $referrer[] = $lead_detail['referrer'];
		  $domain[] = $lead_detail['domain'];
		  $hour+= (int)$time[0];
		  $minutes+= (int)$time[1];
		  $seconds+= (int)$time[2];
		  if(isset($lead_detail['leadType']) and $lead_detail['leadType']!="")
		  {
			  if($lead_detail['leadType']=='1')
			  {
				  $lead_status = "Bilable";
			  }else {
				  $lead_status = "Non-Bilable";
				  }	  
		  }
		  $chat_lead_status[] = $lead_status;
		  $notes[] = $lead_detail['notes']; 
		}
		$total_time = (3600*$hour + 60*$minutes + $seconds)/mysql_num_rows($rs_lead_info) ; 
		$session_time = gmdate("H:i:s", $total_time) ;
		//echo "session time =".$session_time."</br>";
		//echo "DATE"." :"."PROSPECT"." :"."LEADS"." :"."NON-BILABLE"."</br>" ;

	}
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO Chat Detail</title>
	
<style type="text/css">
#colorbox{ width:764px !important;}
#cboxWrapper{ width:764px !important;}
#cboxContent{ width:764px !important;}
#cboxLoadedContent{ width:764px !important;}
.left_column { background:none repeat scroll 0 0 #ecebeb; border-radius:10px; clear:both; float:left !important; margin-bottom:10px; margin-right:200px; padding:10px; position:relative; margin-top:16px;}
.right_column { background:none repeat scroll 0 0 #0084ff; border-radius:10px; clear:both; color:#ffffff; float:right; margin-bottom:10px; margin-left:200px; padding:10px; position:relative; margin-top:16px; }
#chatTranscription { margin:5px auto; width:98%; overflow:scroll; height:500px; overflow-x:hidden; padding-right:20px; }
.leftlabel { bottom:-18px; color:#656668; font:italic 11px/1 Arial,Helvetica,sans-serif; left:8px; position:absolute; }
.rightlabel { bottom:-18px; color:#656668; font:italic 11px/1 Arial,Helvetica,sans-serif; right:8px; position:absolute;}
.arrow-down1 { width:0; height:0; border-left:5px solid transparent; border-right:5px solid transparent; border-top:5px solid #1e85e3; position:absolute; right:21px; top:7px;}
.arrow-down2 { width:0; height:0; border-left:5px solid transparent; border-right:5px solid transparent; border-top:5px solid #1e85e3; position:absolute; right:7px; top:13px;}
.bg-white{position:relative;}
h5 p:hover{ cursor:help;}
.doughtnut label{ font-size:32px; line-height:44.8px; color:#000000 !important;}
.doughtnut h5 p{ font-size:16px; line-height:22.4px;}
.doughtnut label {
  color: #2b2b2b;
  display: inline-block;
  font-size: 30px;
  margin-bottom: 16px !important;
  margin-top: 35px !important;
  text-align: center;
  width: 100%;
  #show-filter-form{ font-size:16px !important; line-height:22.4px !important;}
}
@media only screen and (min-device-width:1280px) and (max-device-width:1366px){

}

@media only screen and (min-device-width:800px) and (max-device-width:1500px){

}
</style>
<?php include('head_include.php');?>
<script>
$(document).ready(function() {
	// Tooltip above and centered, this is the default setting
	$('.Prospectss').jBox('Tooltip');
	$('.Leadss').jBox('Tooltip');
	$('.NonBillables').jBox('Tooltip');
	$('.LeadPercentages').jBox('Tooltip');
	$('.AvgChats').jBox('Tooltip');
});
</script>
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
                                        <a href="javascript:void(0)" id="show-filter-form">Filters <div class="arrow-down1"></div></a>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div id="filter-form" class="filter-form item-hide">
                                    <form method="get">
                                        <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                                    
                                    
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
                                                            <input class="active_btn"  value="Done" style="float:right; cursor:pointer; margin-right:11px; margin-top:10px; width:50px;" onclick="onClose();" />
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
                                                
                                                
                                                <style>
													.filter-form{ width:365px;}
													#custom_drop_form{ width:352px;}
													.menu_container{ position:absolute; width:220px; margin:-26px 0 0 165px; background:#FFFFFF; z-index:1; border:1px solid #d3d3d3; display:none; padding-top:5px;}
													.option{ width:265px; margin:15px 0 18px 88px; position:relative;}
													.option p{ font:bold 12px/1 Arial, Helvetica, sans-serif; width:76px; display:inline;}
                                                	h2#nav { margin-left:10px; border-radius:2px; width:186px; color:#000000; line-height:25px; font-size:14px; padding:5px 5px 5px 10px; cursor:pointer; border:1px solid #d3d3d3; font:12px/1 Arial, Helvetica, sans-serif; display:inline-block; text-transform:uppercase;}
													ol.select { display:none; margin:5px 0 0 5px; width:200px;}
													ol.select > li {line-height:20px; font-size:12px; padding:2px 4px; cursor:pointer; list-style:none; }
													ol.select > li a{ display:block; padding:0 5px; width:200px;}
													ol.select > li:hover, ol.select > li.active { }
													ol.select > li a:hover, ol.select > li a.ctive{ color:#FFFFFF !important; display:block; width:200px; background:#1e86e3; border-radius:2px;}
													#datepickerdivfrom, #datepickerdivto{font-size:9px; width:180px; float:left; position:relative;}
													#datepickerdivfrom label, #datepickerdivto label{ position:absolute; top:-13px; left:0; font:bold 10px/1 Arial, Helvetica, sans-serif; width:69px;}
													#date_picker_holder{width:360px; float:right; display:none; padding:20px 0 15px;}
													.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default,.ui-datepicker th {font-size:9px!important;}
													.activeClass{ background:#1e86e3; border-radius:2px; color:#ffffff !important}
													a:active.activeClassactive, a:hover.activeClassactive, a.activeClass{ color:#FFFFF !important;}
													.amChartsPeriodSelector{ display:none;}
													.chart-box {
													  display: block;
													  margin-top: 15px;
													  position: relative;
													}
                                                </style>
                                                
                                                <script type="text/javascript">
                                                	var nav = $('#nav');
													var selection = $('.select');
													var select = selection.find('li');
													
													nav.click(function(event) {
														if (nav.hasClass('active')) {
															$('.menu_container').hide();
															nav.removeClass('active');
															selection.stop().slideUp(200);
														} else {
															nav.addClass('active');
															$('.menu_container').show();
															selection.stop().slideDown(200);
														}
														event.preventDefault();
													});
													
													select.click(function(event) {
														select.removeClass('active');
														$(this).addClass('active');
														nav.trigger('click');
														//$("#date_range").css({ display:"block" });
														// alert ("location.href = 'index.php?lang=" + $(this).attr('data-value'));
													});
                                                </script>                                      
                                    
<!--                                        <div class="frm_cont_top">
                                        <!--<label class="filter_lbl_view">View:</label>-->
                                           <!-- <br />
                                           <select name="type" onChange="return check_date_range(this.value);" >
                                                <option value="">All</option>    
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="today"){echo "selected"; } ?> value="today">Today</option>
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
                                                <option <?php ///if(isset($_GET["type"]) and $_GET["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Month</option>
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Month</option>
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
                                                <option <?php //if(isset($_GET["type"]) and $_GET["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
                                            </select>
                                            &nbsp;
                                        </div>
                                        <div class="frm_cont_range" <?php //if(isset($_GET["type"]) and $_GET["type"]=="date_range"){  }else{ ?> style="display:none" <?php //} ?> id="date_range">    
                                            <div class="from-wrap">
                                                <label class="from-range">From:</label>
                                                <input type="text" id="from" name="from" value="<?php //if(isset($_GET["from"])){ echo $_GET["from"];   }?>" />
                                            </div>
                                            <div class="clearB"></div>
                                            <div class="to-wrap">
                                                <label class="to-range">To:</label>
                                                <input type="text" id="to" name="to" value="<?php //if(isset($_GET["to"])){ echo $_GET["to"];   }?>" />
                                            </div>
                                        </div>-->
                                       <div class="frm_buttons">        
                                            <input class="active_btn" type="submit" name="search" value="Apply Filter"> 
                                            <input class="default_btn" type="button" value="Reset to Default" onClick="window.location.href=window.location.href">
                                       </div>                                        
                                        <!--<div class="frm_buttons">
                                            <input type="submit" value="Apply Filters" class="active_btn" name="search"  id="cmd_filter">
                                            <input type="submit" id="cmd_default" class="default_btn" value="Reset to Default">
                                        </div>-->
                                   
                                    </form>
                                </div>
                            </div>		
                        </div>          
                        <div class="filter-box-bg item-hide"></div>
                        <div class="clearB"></div>
                        <?php include('pieChartsChat.php'); ?>
                        <div class="chart-box">
                            <div class="doughnut_charts">
                                <div class="doughnut_items_wrap">
                                	<div class="total_call_wrap doughtnut">
                                        <div id="prospects" style="width:100%; height:120px; background-color:#FFFFFF;" ></div>
                                        <div class="doughnut-img-wrap"><div class="icons holder1"></div></div>
                                        <label><?php echo $prospect; ?></label>
                                        <h5><p class="Prospectss" title="Total number of conversations.">Prospects</p></h5>
                                    </div>
                                    <div class="total_call_wrap doughtnut">
                                        <div id="leads" style="width:100%; height:120px; background-color:#FFFFFF;" ></div>
                                        <div class="doughnut-img-wrap"><div class="icons holder2"></div></div>
                                        <label><?php echo $leads; ?></label>
                                        <h5><p class="Leadss" title="Number of qualified leads.">Leads</p></h5>
                                    </div>
                                    <div class="nonbillable doughtnut">
                                        <div id="nonbillable" style="width:100%; height:120px; background-color:#FFFFFF;" ></div>
                                        <div class="doughnut-img-wrap"><div class="icons holder3"></div></div>
                                        <label><?php echo $non_bilable_leads; ?></label>
                                        <h5><p class="NonBillables" title="Number of non charged conversations.">Non Billable</p></h5>
                                    </div>
                                    <div class="ans_call_wrap1 doughtnut">
                                        <div id="leadPercentage" style="width:100%; height:120px; background-color:#FFFFFF;" ></div>
                                        <div class="doughnut-img-wrap"><div class="icons holder4"></div></div>
                                        <label><?php echo $lead_perc.'%'; ?></label>
                                        <h5><p class="LeadPercentages" title="Percentage of leads from prospects.">Lead Percentage</p></h5>
                                    </div>                                    <div class="avg_call_wrap1 doughtnut">
                                        <div id="sessionTime" style="width:100%; height:120px; background-color:#FFFFFF;" ></div>
                                        <div class="doughnut-img-wrap"><div class="icons holder5"></div></div>
                                        <label>
                                        
                                        	<?php 
    											$str = $session_time;
		
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
    										?></label>
                                        <h5><p class="AvgChats" title="Average chat session duration.">Avg. Chat Session (min)</p></h5>
                                    </div>
                                </div>
                                <div class="clearB"></div>
                                <div class="clearB"></div>
                            <?php include('linechartChat.php'); ?> 

                                <div class="linegrap-wrap"><div id="linechartdiv2" style="width:100%; height:350px; background-color:#FFFFFF;" ></div></div>
                            </div>
                        </div>
                        <div class="clearB"></div>
                   
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                    <th width="150">Date</th>
                                    <th width="150">Time</th>
                                    <th width="150">Duration (min)</th>
                                    <th width="230">Location</th>
                                    <th width="120">Lead Status</th>
                                    <th width="120">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							
							$i = 0;
								foreach ($date as $key => $date_value)://echo    $date_value." :".$chat_start_dtm[$key]." :".$chat_duration[$key]." :".$city." ".$state." ".$country." :".$chat_lead_status[$key]." :</br>";//.$notes[$i]."</br>" ;
							?>
							<tr class="odd">
						        <td class="date_data">
                                    <?php  // $date_prefix; echo date(" M 'y - H:i:s",strtotime($date)); ?>
                                    <!--5th May '14 - 11:58:01-->
                                    <?php //echo $date_value; ?>
                                    
                                    <?php 
									$datetime = $date_value; 
									$date_time = explode(" ", $datetime);
									echo $date_time[0];
    								?>
                               	</td>
							    <td><?php //echo $chat_start_dtm[$key].' / '; ?>
                                	<?php 
										$chat_date = $chat_start_dtm[$key];
										$extracted_date = explode(" ", $chat_date);
										
										
										
										//list($hour, $minute, $second) = explode(":", $extracted_date[1]);
										//if($hour > 12){
											//$tsession = "PM";
										//}elseif($hour == 24){
											//$tsession = "AM";
										//}else{
											//$tsession = "AM";
										//}
										
										///if($hour != 00){
											//echo $hour.':'.$minute.' '.$tsession;
										//} else {
											//echo $minute.':'.$second.' '.$tsession;
										//}
										//echo $extracted_date[1];
										$new_date = strtotime($extracted_date[1]);
										$new_date = date('h:i A', $new_date);
										echo $new_date;
									?>
                                </td>
						        <td class="time_data">
								<?php 
									//echo $chat_duration[$key];
									
									list($hour, $minute, $second) = explode(":", $chat_duration[$key]);
									if($minute == 00 || $minute == '' && $second == 00 || $second == ''){
										echo '00:00';
									}else{
										if($hour != 00){
											echo $hour.':'.$minute.':'.$second;
										} else {
											echo $minute.':'.$second;
										}
									}									 
								?></td>
                                <td><?php $location_new = explode(",",$location[$key]);
								          echo $location_new[0]; ?></td>
                              	<td class="call_data"><?php echo $chat_lead_status[$key]; ?></td>
   								<!-- <td align="center"><img src="Images/call-tracking-icon-2.png" /></td>-->
							    <td>
                                   <a class='inline' href="#inline_content<?php echo $key; ?>"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
                            
							<?php $i++; endforeach; ?>
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
	foreach ($date as $key => $date_value)://echo    $date_value." :".$chat_start_dtm[$key]." :".$chat_duration[$key]." :".$city." ".$state." ".$country." :".$chat_lead_status[$key]." :</br>";//.$notes[$i]."</br>" ;
?>

<div style="display:none;" >
    <div id="inline_content<?php echo $key; ?>" class="item_modals">

	<h1 class="item-title">Transcription Details</h1>
       <table width="100%" >
            <tbody>
                <tr>
                    <td align="left" width="200"><b>Date and Time</b></td>
                    <td align="left"><!--5th May ‘14 - 11:51:22--><?php //echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date));?><?php echo $date_value; ?></td>
                </tr>
                <tr>
                    <td align="left" width="200"><b>URL customer was on</b></td>
                    <td align="left"><?php echo $referrer[$key] ;?></td>
                </tr>
                <tr>
                    <td align="left" width="200"><b>Location</b></td>
                    <td align="left"><?php echo str_replace(", 07","",$location[$key]); ?></td>
                </tr>                
            </tbody>
        </table>
        
		<div id="chatTranscription">
        	<?php 
			$str = $notes[$key];
			$str1 = str_replace("Agent:","</br><b>Agent:</b>",$str);
			?>
            <?php 
				$str_exp = explode("Agent:", $str);
				$str_exp2 = explode("Visitor:", $str_exp);
				
				foreach($str_exp as $str_key => $str_value){
					$str_2 = explode("Visitor:", $str_value);  
					foreach($str_2 as $str_key2 => $super_value){
						if($str_key2 > 0){
							echo "<div class='right_column'>{$super_value}<span class='rightlabel'>Visitor</span></div>";
						}else{
							if(($super_value == '') || empty($super_value)){ 
							}else{
								echo "<div class='left_column'>{$super_value}<span class='leftlabel'>Agent</span></div>";
							}
						}						
					}
				}
			?>
        </div>
	</div>
	</div>
<?php endforeach; ?>
<div>


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