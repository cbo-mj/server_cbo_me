<?php
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");

	$client_id = $_GET["id"];
	
	$sql_client = "select distinct al_group_id , al_domain_id from client where client_id = '$client_id' and  al_group_id!='' and al_domain_id!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
		 $al_group_id = $client_detail['al_group_id'];
		 
		 $al_domain_id = $client_detail['al_domain_id'];
		  
	}
	
/*	$al_group_id = 5596 ;
	$al_domain_id = 190191 ;*/
	
$sql_rank_client = "SELECT distinct b.name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank ,  CASE a.`google_change` WHEN '' THEN 0 ELSE a.`google_change` END g_change, google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks` a
INNER JOIN authority_lab_keywords b ON a.`keywords_id` = b.`keywords_id`
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id and a.`rank_date`
IN (
SELECT max( a.`rank_date` )
FROM authority_lab_ranks a WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id
)" ; 

$rs_rank_client = mysql_query($sql_rank_client) or die ( mysql_error() );	

if(mysql_num_rows($rs_rank_client) > 0 )
	{
		//$client_rank_detail = mysql_fetch_assoc($rs_rank_client);
		while($client_rank_detail = mysql_fetch_assoc($rs_rank_client))
		{
		 $name[] = $client_rank_detail['name'];
		 $google_rank[] = $client_rank_detail['google_rank'];
		 $g_change[] = $client_rank_detail['g_change'];
		 $volume[] = $client_rank_detail['volume'];
		 $map[] = $client_rank_detail['map'];
		 $images[] = $client_rank_detail['images'];
		 $video[] = $client_rank_detail['video'];
		 $blog[] = $client_rank_detail['blog'];
		 $news[] = $client_rank_detail['news'];
		 $shopping[] = $client_rank_detail['shopping'];
		 $micro_format[] = $client_rank_detail['micro_format'];
		}
		  
	}	
echo "KEYWORD"." : "."GOOGLE RANK"." : "."GOOGLE CHANGE"." : "."VOLUME"." : "."MAP"." : "."IMAGES"." : "."VIDEO"." : "."BLOG"." : "."NEWS"." : "."SHOPPING"." : "."MICRO FORMAT"."</br>" ;
		  
	$i=0;
	foreach ($name as $name_value) {
       
	echo    $name_value." : ".$google_rank[$i]." : ".$g_change[$i]." : ".$volume[$i]." : ".$map[$i]." : ".$images[$i]." : ".$video[$i]." : ".$blog[$i]." : ".$news[$i]." : ".$shopping[$i]." : ".$micro_format[$i]."</br>" ;
	   $i++;
}

//die;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>
<?php include('head_include.php');?>
</head>

<body class="hybrid" style="overflow-x:hidden;">
    
<table width="70%" border="1">
  <tbody>
    <tr>
      <th scope="col">Keywords</th>
      <th scope="col">Current Rank</th>
      <th scope="col">+/-</th>
      <th scope="col">Volume</th>
      <th scope="col">Result Type</th>
    </tr>
      <?php foreach($name as $key => $name_value): ?>
    <tr>
      <th scope="row"><?php echo $name_value; ?></th>
      <td><?php echo $google_rank[$key]; ?></td>
      <td><?php echo $g_change[$key]; ?></td>
      <td><?php echo $volume[$key]; ?></td>
      <td><?php echo $map[$key].' '.$images[$key].' '.$video[$key].' '.$blog[$key].' '.$news[$key].' '.$shopping[$key].' '.$micro_format[$key]; ?></td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>

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
                                                <!--<div class="frm_cont_top">-->            
                                                        <?php
                                                            $sql_check_account = 
                                                            "
                                                            SELECT * 
                                                            FROM  `ga_account`  where account_id = '$account_id' 
                                                            ";
                                                        ?>              
                                                        <!--<label class="filter_lbl_view">Account: </label>
                                                        <select name="accountSelector">-->  
														<?php $rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
                                                            if(mysql_num_rows($rs_account)>0){
                                                            	while($ga_account_detail = mysql_fetch_assoc($rs_account)){?>
                                                                   <!-- <option <?php //if($_POST['accountSelector']==$ga_account_detail['account_id']){ echo 'selected';}?> value="<?php //echo $ga_account_detail['account_id'];?>"><?php //echo $ga_account_detail['account_name'];?></option>
                                                        
                                                        	
                                                    </select>--> 
													<input type="hidden" name="accountSelector" value="<?php echo $ga_account_detail['account_id'];?>" />
													<?php }}?>       
                                                <!--</div>--><!-- END .frm_cont_top -->
                                               
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
												         
                                                function submit_form(account_id) {
                                                    var str = "";
                                                    str = "account_id=" + account_id;
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
                                                        alert("Request failed: " + textStatus);
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
                                                ?>
                                                
                                                <input type="hidden" value="<?php echo $profile_id;?>" name="webproperty-dd" />
                                                
                                                <!--<label class="filter_lbl_view">Property: </label>
                                                    <select name="webproperty-dd" >
                                                    <?php
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
                                                    
                                                </select>-->
                                                <div class="frm_cont_top" style="height:64px !important;">
                                                    <select name="type" onChange="return check_date_range(this.value);" >
                                                        <option value="">Please select</option>    
                                                        <!-- <option <?php if(isset($_GET["type"]) and $_GET["type"]=="today"){echo "selected"; } ?> value="today">Today</option>-->
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Months</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Months</option>
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
                                                        <option <?php if(isset($_POST["type"]) and $_POST["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
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
				$total_ga_sessions += $ga_30_days_detail['ga_sessions'];
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







</div>

</div>

</body>




</html>