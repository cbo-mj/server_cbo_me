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
				<a href="javascript:void(0)" id="show-filter-form">Filters <span class="icon-arrow"></span></a>
				
			</div>
			<div class="line"></div>
		</div>
        
        <div id="filter-form" class="filter-form item-hide">
        
		<form method="post">
       
       <input type="hidden" value="<?php echo $account_id;?>" name="accountSelector" /> 
        
        
        
  	<!--<div class="frm_cont_top">
    
	<?php $sql_check_account = "SELECT * FROM  `ga_account`  where account_id = '$account_id' "; ?>  
    
    <label class="filter_lbl_view">Account: </label>
    <select name="accountSelector"  >
             
     <?php

										
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
 </div>-->  
   
   <script type="text/javascript">
   
	$(document).mouseup(function (e)
	{
	   var container = $("#filter-form");
	
	   if (!container.is(e.target) // if the target of the click isn't the container...
		   && container.has(e.target).length === 0) // ... nor a descendant of the container
	   {
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
  
<?php

$firstAccountId = $account_id;
	
	 $sql_check_account = 
		"
		SELECT * 
		FROM  `ga_property` 
		where 
		account_id = '$firstAccountId' and profile_id = '$profile_id' 
		
		
		";

/* $sql_campaign = "
SELECT `campaign_id`,`campaign_name` FROM aw_campaign_details WHERE `campaign_id` IN 
(SELECT DISTINCT `adwordsCampaignID` FROM `ga_adword_campaign_data_30_days` WHERE `account_id`='$firstAccountId' AND `profile_id`='$profile_id') ";*/

$sql_campaign = "SELECT `group_campaign_id` as campaign_id,`campaign_name` FROM group_campaign WHERE client_id = '$client_id' " ;
?>
    
    
    <input type="hidden" value="<?php echo $profile_id;?>" name="webproperty-dd" />
    <div class="frm_cont_top"> 
   <label class="filter_lbl_view">Campaign: </label>
	<select name="campaign_id" >
    <option value="">All Campaigns</option>   
    <?php
	
										
	$rs_campaign = mysql_query($sql_campaign) or die ( mysql_error() ) ;
	
	if(mysql_num_rows($rs_campaign)>0)
	{
	 while($ga_campaign_detail = mysql_fetch_assoc($rs_campaign))
	 {
		// pr($ga_property_detail);
	?>
		<option <?php if($_POST['campaign_id']==$ga_campaign_detail['campaign_id']){ echo 'selected';}?> value="<?php echo $ga_campaign_detail['campaign_id'];?>"><?php echo $ga_campaign_detail['campaign_name'];?></option>
    <?php
	}
}
	?>	
</select> 

    </div>
   
 <div class="frm_cont_top">
 <select name="type" onChange="return check_date_range(this.value);" >
				<option value="">Please select</option>    
				<!--<option <?php if(isset($_POST["type"]) and $_POST["type"]=="today"){echo "selected"; } ?> value="today">Today</option>-->
				<!--<option <?php if(isset($_POST["type"]) and $_POST["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>-->
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Months</option>
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Months</option>
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
				<option <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
			</select>
</div>

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
		</div>
        
   <!--<label class="filter_lbl_view"><input type="submit" name="submit" value="Search"> </label>-->
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
	
		// today day
	
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
			
			$date_sql = " and ga.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
					 AND ga.date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY	";
			
			
		}else if($type=="last_month")
		{	
					 
			$date_sql = " and YEAR(ga.date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(ga.date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)	";
			
			
		}else if($type=="last_3_month")
		{
				 
					 
			$date_sql = " and date(ga.date ) >= now()-interval 3 month	";
					 
			
		}else if($type=="last_6_month")
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
		 
		 // $date_sql
	 
	 	 $account_id = $_POST['accountSelector'];
		 $profile_id = $_POST['webproperty-dd'];
		 $campaign_id  = $_POST['campaign_id'];
		 
		 if($campaign_id!="")
		 {
			 
			   $sql_camp_link = "select * from group_campaign_link where group_campaign_id = '$campaign_id' and client_id = '$client_id' ";
			 $rs_campaign_new_link = mysql_query($sql_camp_link) or die ( mysql_error() );
			 
			 if(mysql_num_rows($rs_campaign_new_link)>0)
			 {
			 	//$campaign_id_link = array();
			 	while($row_camp_link_new = mysql_fetch_assoc($rs_campaign_new_link))
			 	{
					
				 	$campaign_id_link[] = $row_camp_link_new['campaign_id'];
				}
			 }
			 
			 
			// pr($campaign_id_link);
			 
			 if(!empty($campaign_id_link))
			 {
					$campaign_id_link = implode(",",$campaign_id_link); 
					if($campaign_id_link!="")
					{
						$campaign_id = $campaign_id_link;
					}
			 }
		 
		   if($date_sql=="")
		     {
		 
	 $sql =" select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents,ifnull(sum(ca.total_call),0) as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_30_days ga left join campaign_event_30_day gaw on ga.date = gaw.date and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id' and ga.`adwordsCampaignID` in($campaign_id) and gaw.adwordsCampaignID in($campaign_id) group by ga.date) gaf left join (select date(c.date) as date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by date(c.date), c.client_id) ca on gaf.date = date(ca.date) group by gaf.date order by gaf.date    ";
		 
			 }
			  else { 
			 
		     $sql =" select gaf.date as date, ifnull(sum(gaf.impressions),0) as impressions, ifnull(sum(gaf.adClicks),0) as adClicks, sum(gaf.CTR) as CTR, ifnull(sum(gaf.totalEvents),0) as totalEvents,ifnull(sum(ca.total_call),0) as total_call from (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents from ga_adword_campaign_data_30_days ga left join campaign_event_30_day gaw on ga.date = gaw.date and ga.`adwordsCampaignID` = gaw.adwordsCampaignID where ga.account_id = '$account_id' and ga.profile_id = '$profile_id' and ga.`adwordsCampaignID` in($campaign_id) and gaw.adwordsCampaignID in($campaign_id) $date_sql group by ga.date) gaf left join (select date(c.date) as date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by date(c.date), c.client_id) ca on gaf.date = date(ca.date) group by gaf.date order by gaf.date         ";
			 
			 
			 }
		 
		 // and c.client_id = '$client_id' 
	     	$rs_30_days = mysql_query($sql);
		 
		
		
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
			 
		 }
	
else if($date_sql!="" and $campaign_id==""){
		  $sql = "select gaw.date as date, ifnull(sum(gaw.impressions),0) as impressions, ifnull(sum(gaw.adClicks),0) as adClicks, sum(gaw.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents, ifnull(sum(ca.total_call),0) as total_call from
		  (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(ga.totalEvents),0) as totalEvents  from ga_adword_event_data_history ga  where ga.account_id = '$account_id' and ga.profile_id = '$profile_id' $date_sql group by ga.date) gaw 
		  left join (select c.date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by c.date, c.client_id) ca on gaw.date = date(ca.date) group by gaw.date order by gaw.date";
		 
	     	$rs_30_days = mysql_query($sql) or die ( mysql_error() );
		
		 mysql_num_rows($rs_30_days);
		
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
}else if($date_sql=="" and $campaign_id==""){
	
	
		 
			 
			 
			 $sql = "select gaw.date as date, ifnull(sum(gaw.impressions),0) as impressions, ifnull(sum(gaw.adClicks),0) as adClicks, sum(gaw.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents, ifnull(sum(ca.total_call),0) as total_call from
		  (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(ga.totalEvents),0) as totalEvents  from ga_adword_event_data_30_days ga  where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  group by ga.date) gaw 
		  left join (select c.date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by c.date, c.client_id) ca on gaw.date = date(ca.date) group by gaw.date order by gaw.date" ;
	     	$rs_30_days = mysql_query($sql) or die ( mysql_error()  );
		 
		
		
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
	
}

	  }




}


if(!isset($_POST["submit"]))
{
		 
			 
			 
			 $sql = "select gaw.date as date, ifnull(sum(gaw.impressions),0) as impressions, ifnull(sum(gaw.adClicks),0) as adClicks, sum(gaw.CTR) as CTR, ifnull(sum(gaw.totalEvents),0) as totalEvents, ifnull(sum(ca.total_call),0) as total_call from
		  (select ga.date as date, ifnull(sum(ga.impressions),0) as impressions, ifnull(sum(ga.adClicks),0) as adClicks, sum(ga.CTR) as CTR, ifnull(sum(ga.totalEvents),0) as totalEvents  from ga_adword_event_data_30_days ga  where ga.account_id = '$account_id' and ga.profile_id = '$profile_id'  group by ga.date) gaw 
		  left join (select c.date, c.client_id, count(*) as total_call from call_log c where c.client_id = '$client_id' group by c.date, c.client_id) ca on gaw.date = date(ca.date) group by gaw.date order by gaw.date" ;
	     	$rs_30_days = mysql_query($sql) or die ( mysql_error()  );
		 
		
		
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
}
?>


<?php include('piechart_sem.php');?>
<style>
	.piechart h2, .piechart h6{ text-align:center; padding-right:0;}
	.piechart{ width:20%; float:left; position:relative; }
	.chart_holder{ width: 100%; height: 150px; margin:0 auto;  }
	#ImpressionsChart{ background:url(icons/impressions.png) center center no-repeat;}
	#ClicksChart{ background:url(icons/clicks.png) center center no-repeat;}
	#EventsChart{ background:url(icons/events.png) center center no-repeat;}
	#CallsChart{ background:url(icons/calls.png) center center no-repeat;}
	#RatiosChart{ background:url(icons/customer-engagement.png) center center no-repeat;}
	span.ImpressionsChart:hover, span.Clicks:hover, span.Events:hover, span.Calls:hover, span.CustomerEngagement:hover{ cursor:help;}
	
	h6.device_name{ text-transform:capitalize;}
	#PieChartContainer{ width:330px; float:right;}
	.piechart2{ width:33.3%; float:left; position:relative; }
	.piechart2 h1, .piechart2 h3, .piechart2 h6{ text-align:center; padding-right:0;}
	.chart_holder2{ width: 100%; height: 150px; margin:0 auto;  }
	#desktop{ background:url(icons/desktop-icon.png) center center no-repeat; background-size:34px 34px;} 
	#mobile{ background:url(icons/phone-icon.png) center center no-repeat; background-size:34px 34px;} 
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
		
	
	
	@media only screen and (min-device-width:1280px) and (max-device-width:1366px){
		#main_container{ width:920px!important;}
	}
	
	@media only screen and (min-device-width:800px) and (max-device-width:1500px){
		#main_container{ width:1080px;}
		
	}
</style>
<script>
$(document).ready(function() {
	// Tooltip above and centered, this is the default setting
	$('.Impressions').jBox('Tooltip');
	$('.Clicks').jBox('Tooltip');
	$('.Events').jBox('Tooltip');
	$('.Calls').jBox('Tooltip');
	$('.CustomerEngagement').jBox('Tooltip');
});
</script>
<?php 

	
//echo "sum_impression = $sum_impression <br/>";
//echo "sum_adClicks = $sum_adClicks <br/>";
//echo "sum_TotalEvent = $sum_TotalEvent <br/>";
//echo "sum_total_call = $sum_total_call <br/>";
//echo "sum_call_click_ratio = $sum_call_click_ratio % <br/>";


?>
<div id="main_container">
<div class="piechart"> 
	<div id="ImpressionsChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_impression); ?></h2>
	<h6><span class="Impressions" title=" The number of times your ad has been shown.">Impressions</span></h6>
</div>
<div class="piechart"> 
	<div id="ClicksChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_adClicks); ?></h2>
	<h6><span class="Clicks" title="The number of click on your ads.">Clicks</span></h6>
</div>
<div class="piechart"> 
	<div id="EventsChart" class="chart_holder"></div>
	<h2><?php echo number_format($sum_TotalEvent); ?></h2>
	<h6><span class="Events" title="The amount of interactions users <br />had after arriving on your site.">Events</span></h6>
</div>
<div class="piechart"> 
	<div id="CallsChart" class="chart_holder"></div>
	<h2><?php if($sum_total_call == 0){ echo '0';}else{ echo $sum_total_call;} ?></h2>
	<h6><span class="Calls" title="The number of calls directly from your ads.">Calls</span></h6>
</div>
<div class="piechart"> 
	<div id="RatiosChart" class="chart_holder"></div>
	<h2><?php echo round($sum_TotalEvent / $sum_adClicks * 100).'%'; //echo round($sum_call_click_ratio,2).'%';?></h2>
	<h6><span class="CustomerEngagement" title="The percentage of users who <br />take direction from your site.">Customer Engagement</span></h6>
</div>
<div style="clear:both;"></div>
<br />
<?php 

$i=0;

//echo '<pre>';
	//asort($date);
	//print_r($date);
	//print_r($impressions);
	//print_r($$adClicks);
	//print_r($CTR);
	//print_r($TotalEvent);
	//print_r($total_call);
	//print_r($call_click_ratio);
//echo '</pre>';
//echo "Date : Impressions : Clicks : CTR : Total Event : Total call : Click to call Ratio"."</br>";
//foreach($date as $date_value)
//{
	//echo "$date_value : ".$impressions[$i]." : ".$adClicks[$i]." : ".$CTR[$i]." : ".$TotalEvent[$i]." : ".$total_call[$i]." : ".$call_click_ratio[$i]."<br/>";
//$i++;		
//}

?>

<?php include('stockchart_sem.php'); ?>
<div style="clear:both;"></div>


<?php  //include('../../call_tracking/linechart.php');?>


<div id="StockChart" style="width: 100%; height: 500px; background-color: #FFFFFF;"></div>		
<!--<div id="linechartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;"></div>-->



</div>

</div>

</body>




</html>