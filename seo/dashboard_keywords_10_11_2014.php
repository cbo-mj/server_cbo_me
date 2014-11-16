<?php
//error_reporting(0);
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
		  
	} else { 
	
	   //echo "GROUP & DOMAIN is not set for this client, Please set it in the client page to see data in the keyword dashboard" ; 
	   include('error_page.html');
	   
	   die; 
	}
	
/*	$al_group_id = 5596 ;
	$al_domain_id = 190191 ;*/
	
if(isset($_POST["submit"]))
{
	
	
	$date_sql = '';	
	
	if(isset($_POST["type"]) and $_POST["type"]!="")
	{
		$type = $_POST["type"];
		
		if($type=="today" or $type=="yesterday" or $type=="")
		{
			
		}
		if($type=="today")
		{
			$today_date = date( "Y-m-d" );
			$date_sql = "and date(c.`rank_date) = '$today_date' ";
		}else if($type=="yesterday")
		{
			$yesterday_date = date('Y-m-d ', strtotime(" -2 day "));
			$date_sql = "and date(c.`rank_date`) = '$yesterday_date' ";
		}else if($type=="last_week")
		{
			$date_sql = " and c.`rank_date` = curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY";
		}else if($type=="last_month")
		{	
			$date_sql = " and date(c.`rank_date` ) = now()-interval 1 month	";
		}else if($type=="last_3_months")
		{
			$date_sql = "  and date(c.`rank_date` ) = now()-interval 3 month		";
		}else if($type=="last_6_months")
		{
			$date_sql = "  and date(c.`rank_date` ) = now()-interval 6 month		";
		}else if($type=="last_year")
		{
			$date_sql = " and  c.`rank_date` = DATE_SUB(NOW(),INTERVAL 1 YEAR)		";
		}else if($type=="date_range")
		{
			$from_date = $_POST["from"];
			$to_date = $_POST["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));
			$date_sql = " and  c.`rank_date` between '$from_date' AND '$to_date'		";
		}
	
	
	
	//echo $date_sql; die;
	
/*	 	 $account_id = $_POST['accountSelector'];
		 $profile_id = $_POST['webproperty-dd'];*/
		 if($date_sql=="")
		 {
		
	 $sql_rank_client = "SELECT distinct a.keyword_name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank ,  CASE a.`google_change` WHEN '' THEN 0 ELSE a.`google_change` END g_change, a.google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks_30_days` a
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id and a.`rank_date`
IN (
SELECT max( a.`rank_date` )
FROM authority_lab_ranks_30_days a WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id
)" ; 

		 }
		
	 }
	 
}
else { 

  $sql_rank_client = "SELECT distinct a.keyword_name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank ,  CASE a.`google_change` WHEN '' THEN 0 ELSE a.`google_change` END g_change, a.google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks_30_days` a
INNER JOIN (
SELECT max(`rank_date` ) as rank_date
FROM authority_lab_ranks_30_days WHERE group_id = $al_group_id and domain_id = $al_domain_id
) b on a.rank_date = b.rank_date 
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id " ; 

}
 if($date_sql!="")
		 {
			 
					if($type=="today" or $type=="yesterday" or $type=="last_week")
					{
						
							 
 $sql_rank_client = "SELECT distinct a.keyword_name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank , CASE c.`google_rank` WHEN '' THEN a.`google_rank` ELSE a.`google_rank` - c.`google_rank` END g_change, a.google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks_30_days` a left join 
`authority_lab_ranks_30_days` c ON 
a.`keywords_id` = c.`keywords_id` and
a.domain_id = c.domain_id and 
a.group_id = c.group_id $date_sql  INNER JOIN (
SELECT max(`rank_date` ) as rank_date
FROM authority_lab_ranks_30_days WHERE group_id = $al_group_id and domain_id = $al_domain_id
) b on a.rank_date = b.rank_date 
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id   
 order by a.keyword_name"  ; 	
						
						
						
					}else{	
					
						 
		 $sql_rank_client = "SELECT distinct a.keyword_name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank , CASE c.`google_rank` WHEN '' THEN a.`google_rank` ELSE a.`google_rank` - c.`google_rank` END g_change, a.google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks_30_days` a left join 
`authority_lab_ranks_365_days` c ON 
a.`keywords_id` = c.`keywords_id` and
a.domain_id = c.domain_id and 
a.group_id = c.group_id $date_sql INNER JOIN (
SELECT max(`rank_date` ) as rank_date
FROM authority_lab_ranks_30_days WHERE group_id = $al_group_id and domain_id = $al_domain_id
) b on b.rank_date = a.rank_date 
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id  
 order by a.keyword_name"  ; 	
					
					}

		 }
	

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
		 
		 
		 $key_name = mysql_escape_string( $client_rank_detail['name'] );
		 	

		}
		  
	}	


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO SEO Keywords</title>

<style>
.filter-form{width:365px}#custom_drop_form{width:352px}.menu_container{position:absolute;width:220px;margin:-26px 0 0 165px;background:#FFF;z-index:1;border:1px solid #d3d3d3;display:none;padding-top:5px}.option{width:265px;margin:15px 0 18px 88px;position:relative}.option p{font:700 12px/1 Arial,Helvetica,sans-serif;width:76px;display:inline}h2#nav{margin-left:10px;border-radius:2px;width:186px;color:#000;line-height:25px;padding:5px 5px 5px 10px;cursor:pointer;border:1px solid #d3d3d3;font:12px/1 Arial,Helvetica,sans-serif;display:inline-block;text-transform:uppercase}ol.select{display:none;margin:5px 0 0 5px;width:200px}ol.select>li{line-height:20px;font-size:12px;padding:2px 4px;cursor:pointer;list-style:none}ol.select>li a{display:block;padding:0 5px;width:200px}ol.select>li a.ctive,ol.select>li a:hover{color:#FFF!important;display:block;width:200px;background:#1e86e3;border-radius:2px}#datepickerdivfrom,#datepickerdivto{font-size:9px;width:180px;float:left;position:relative}#datepickerdivfrom label,#datepickerdivto label{position:absolute;top:-13px;left:0;font:700 10px/1 Arial,Helvetica,sans-serif;width:69px}#date_picker_holder{width:360px;float:right;display:none;padding:20px 0 15px}.ui-datepicker th,.ui-state-default,.ui-widget-content .ui-state-default,.ui-widget-header .ui-state-default{font-size:9px!important}.activeClass{background:#1e86e3;border-radius:2px;color:#fff!important}a.activeClass,a:active.activeClassactive,a:hover.activeClassactive{color:#FFFFF!important}.piechart h1,.piechart h6{text-align:center;padding-right:0}.piechart{width:16.6%;float:left;position:relative}.chart_holder{width:100%;height:150px;margin:0 auto}.icons{width:34px;height:34px;position:absolute;left:42%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}h6.device_name{text-transform:capitalize}#PieChartContainer{width:350px;float:right}.piechart2{width:115.5px;float:left;position:relative}.piechart2 h1,.piechart2 h3,.piechart2 h6{text-align:center;padding-right:0}.piechart2 .icon_dev{position:absolute;top:60px;left:41px;width:34px;height:34px;background:url(icons/devices.png)}.icon_dev.img2{background-position:0 78px}.icon_dev.img3{background-position:0 34px}.chart_holder2{width:100%;height:150px;margin:0 auto}#desktop{background-size:34px 34px}#main_container{max-width:1200px;margin:0 auto}#StockChart{width:92%;height:500px;margin:0 auto}

@media only screen and (min-device-width:1280px) and (max-device-width:1366px) {#main_container{width:920px}.icons{width:34px;height:34px;position:absolute;left:40%;top:22%;background:url(icons/icons.png)}.content2{background-position:0 -44px}.content3{background-position:0 166px}.content4{background-position:0 123px}.content5{background-position:0 78px}.content6{background-position:0 34px}
}
span.AvgPagesViewed:hover,span.AvgTime:hover,span.BounceRate:hover,span.NewVisitors:hover,span.PageViews:hover,span.TotalVisitors:hover{cursor:help}.arrow-down1{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:21px;top:7px}.arrow-down2{width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid #1e85e3;position:absolute;right:7px;top:13px}.bg-white{position:relative}
</style>

<style>
#keywords_container{ max-width:1185px; margin:0 auto;}
#call_tracking_record th.center{ text-align:center !important;}
#call_tracking_record tr.nobg th{ background:none !important;  padding: 8px 10px 4px;}
th.border{border-left: 1px solid #dbdbdb !important; border-right: 1px solid #dbdbdb !important; border-top:1px solid #dbdbdb !important;}
th.top{border-top:1px solid #dbdbdb !important;}
#call_tracking_record tr.odd, #call_tracking_record tr.even{border-left: 1px solid #dbdbdb !important; border-right: 1px solid #dbdbdb !important;}
tr[role=row] td:first-child {border-left:1px solid #dbdbdb;}
tr[role=row] td:last-child {border-right:1px solid #dbdbdb;}
table tr:nth-of-type(even) { background:#dbdbda; }
.heading{background: none repeat scroll 0 0 #c9c9c9 !important;}
.grank{ color:#1e86e3 !important; font-weight:bold;}
span img:hover{ cursor:help;}
table thead{ background:none !important;}
</style>

<?php include('head_include_keywords2.php');?>
<script>
$(document).ready(function() {
	// Tooltip above and centered, this is the default setting
	$('.GooglePlus').jBox('Tooltip');
	$('.Keywords').jBox('Tooltip');
	$('.CurrentRank').jBox('Tooltip');
	$('.Position').jBox('Tooltip');
	$('.Volume').jBox('Tooltip');
	$('.ResultType').jBox('Tooltip');
	
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
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "yesterday"; ?>');">Previous day</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_week"; ?>');">Previous 7 days</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_month"; ?>');">Previous 30 days</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_3_months"; ?>');">Previous 90 days</a></li>
<!--                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_6_months"; ?>');">Last 6 Months</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "last_year"; ?>');">Last Year</a></li>
                                                            <li><a href="javascript:void(0);" onclick="javascript:check_date_range2('<?php echo "date_range"; ?>');" class="date_range">Date Range</a></li>-->
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
	<div id="keywords_container">				
        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
     		<thead>
                <tr class="nobg">
                    <th width="250">&nbsp;</th>
                    <th colspan="2" class="center border"><span class="GooglePlus" title="One Google Account for everything Google."><img src="keywords/icons/google.png"></span></th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>            	
                <tr class="heading">
                    <th width="40%"><span class="Keywords" title="Search term used">Keyword</span></th>
                    <th width="20%" class="center"><span class="CurrentRank" title="Position in the organic search results">Current Rank</span></th>
                    <th width="5%" class="center"><span class="Position" title="Change in position over the selected date period">+/-</span></th>
                    <th width="20%" class="center"><span class="Volume" title="Average monthly searches">Volume</span></th>
                    <th width="15%"><span class="ResultType" title="Details about the type of results found in the results page">Result Type</span></th>                                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($name as $key => $name_value): ?>
                <tr class="odd">
                    <td class="date_data"><?php echo $name_value; ?></td>
                    <td align="center" class="grank">
						<?php 
							if($google_rank[$key] !=0){ echo $google_rank[$key]; }else{ echo '-';}
						?>
                    </td>
                    <td class="time_data" align="center">
						<?php 
							if($g_change[$key] !=0){ echo $g_change[$key]; }else{ echo '-';}
						?>
                    </td>
                    <td align="center"><?php echo number_format($volume[$key]); ?></td>
                    <td class="call_data"><?php //echo $map[$key].' '.$images[$key].' '.$video[$key]; ?>
                    	<?php 
							if($map[$key] != 0){ echo " <span data-tooltip='Local results found'><img src='keywords/icons/maps.png'></span> "; }
							if($images[$key] != 0){ echo " <span data-tooltip='Image results found'><img src='keywords/icons/image_icon.png'></span> "; }
							if($video[$key] != 0){ echo " <span data-tooltip='Video results found'><img src='keywords/icons/video.png'></span> "; }
							if($blog[$key] != 0){ echo " <span data-tooltip='Blogs results found'><img src='keywords/icons/blog.png'></span> ";}
							if($news[$key] != 0){ echo " <span data-tooltip='News results found'><img src='keywords/icons/news.png'></span> ";}
							if($shopping[$key] != 0){ echo " <span data-tooltip='Shopping results found'><img src='keywords/icons/shopping.png'></span> ";}
							if($micro_format[$key] != 0){ echo " <span data-tooltip='Rich snippets results found'><img src='keywords/icons/micro_format.png'></span> ";}
						?>                  
                    </td>
                </tr>
			<?php endforeach; ?>                
            </tbody>
        </table>
	</div>       
</div>

</div>

</div>
</body>
</html>