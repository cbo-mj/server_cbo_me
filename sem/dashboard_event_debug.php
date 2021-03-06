<?php

include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];
	$sql_client = "select distinct account_id , profile_id from client where client_id = '$target_number' and  account_id!='' and profile_id!=''  ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		 $account_id = $client_detail['account_id'];
		 $profile_id = $client_detail['profile_id'];
	} else { 
	
		echo "No event found for this client " ; die;
	}

	
	$sql_event_detail = "select a.* from ga_event_category_data_30_days a  inner join 
	group_campaign_link c on a.adwordsCampaignID = c.campaign_id inner join group_campaign b on
	b.group_campaign_id = c.group_campaign_id
	where a.account_id LIKE '%$account_id%' and b.client_id = $target_number and b.campaign_type = 4 and
	a.profile_id like '%$profile_id%' and a.medium = 'cpc' ";
	$where ='';
	$order = " order by date desc" ;
	
	$sql_year_graph =  "SELECT sum(c.impressions) as impressions, sum(c.clicks) as clicks, sum(a.`event`) as event from ((SELECT a.date,a.adwordsCampaignID, sum(a.`totalEvents`) as `event` FROM `ga_event_category_data_365_days` a GROUP BY a.date,a.adwordsCampaignID) a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id inner join (SELECT c.date, c.adwordsCampaignID, sum(c.impressions) as impressions, sum(c.adClicks) as clicks from ga_adword_campaign_data_history c group by c.date, c.adwordsCampaignID) c on a.adwordsCampaignID = c.adwordsCampaignID and a.date = c.date) WHERE b.campaign_type = 4 and b.client_id = '$target_number' and date(c.date )>= now()-interval 12 month and date(a.date )>= now()-interval 12 month";
	 
if($_GET["search"])
{
	if(isset($_GET["type"]) and $_GET["type"]!="")
	{
		$sql_event_detail = "select * from ga_event_category_history_data a  inner join 
	group_campaign_link c on a.adwordsCampaignID = c.campaign_id inner join group_campaign b on
	b.group_campaign_id = c.group_campaign_id
	where a.account_id LIKE '%$account_id%' and b.client_id = $target_number and b.campaign_type = 4 and
	a.profile_id like '%$profile_id%' and a.medium = 'cpc' ";
		$type = $_GET["type"];
		// today day
		if($type=="today"){
			$today_date = date( "Y-m-d" );
			$where = " and date(a.date) = '$today_date' ";
		}else if($type=="yesterday"){
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = " and date(a.date) = '$yesterday_date' ";
		}else if($type=="last_week"){
			$where = " and a.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+ 5 DAY
					 AND a.date < curdate() - INTERVAL DAYOFWEEK(curdate())-2 DAY ";
		}else if($type=="last_month"){		 
           $where = "	and date(a.date ) >= now()-interval 1 month " ;
		}else if($type=="last_3_months"){
             $where = " and date(a.date ) >= now()-interval 3 month " ;
		}else if($type=="last_6_months"){
			$where = " and date(a.date ) >= now()-interval 6 month" ;	
		}else if($type=="last_year"){
			$where = " and a.date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)" ;
		}else if($type=="date_range"){
			$from_date = $_GET["from"];
			$to_date = $_GET["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));

            $where = "and a.date between '$from_date' AND '$to_date' " ;	
			
			 $sql_year_graph =  "SELECT sum(c.impressions) as impressions, sum(c.clicks) as clicks, sum(a.`event`) as event from ((SELECT a.date,a.adwordsCampaignID, sum(a.`totalEvents`) as `event` FROM `ga_event_category_data_365_days` a GROUP BY a.date,a.adwordsCampaignID) a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id inner join (SELECT c.date, c.adwordsCampaignID, sum(c.impressions) as impressions, sum(c.adClicks) as clicks from ga_adword_campaign_data_history c group by c.date, c.adwordsCampaignID) c on a.adwordsCampaignID = c.adwordsCampaignID and a.date = c.date) WHERE b.campaign_type = 4 and b.client_id = '$target_number' $where";		
		}
		}
}

$sql_event_detail = $sql_event_detail.$where.$order ;
$rs_event_detail = mysql_query($sql_event_detail) or die ( mysql_error() );	
$rs_year_graph_data = mysql_query($sql_year_graph) or die ( mysql_error() ); 

  if(mysql_num_rows($rs_year_graph_data)>0){  
                                while($ga_year_graph_data = mysql_fetch_assoc($rs_year_graph_data)){
                                  $impression[] = $ga_year_graph_data['impressions'];
                                  $click[] = $ga_year_graph_data['clicks'];
                                  $event[] = $ga_year_graph_data['event'];
                                }
                            }
							
							echo " Event by the year graph: "."</br>";
							echo "IMPRESSION"." : "."CLICK"." : "."EVENT"."</br>" ;
								  
							$i=0;
							foreach ($impression as $impression_value) {
								echo    $impression_value." : ".$click[$i]." : ".$event[$i]."</br>" ;
								$i++;
							}						
	
	if(mysql_num_rows($rs_event_detail) > 0 )
	{
		while($event_30_days_detail = mysql_fetch_assoc($rs_event_detail))
		{
		//pr($client_detail);
	    $date[] = $event_30_days_detail['date'];
		$hour = $event_30_days_detail['hour'];
		$minute = $event_30_days_detail['minute'];
		$time[] = $hour.":".$minute ;
		$eventCategory[] = $event_30_days_detail['eventCategory'];
		$eventAction[] = $event_30_days_detail['eventAction'];
		$eventLabel[] = $event_30_days_detail['eventLabel'];
		
		}
	}
	else if(isset($type) and $type!=" ") 
	{
		//echo "Sorry there are no events during this time period" ;   
		include('dashboard_event_error.php');
		die;
		
	} 

	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>Events Detail</title>
	
<style type="text/css">
#colorbox{ width:764px !important;}
#cboxWrapper{ width:764px !important;}
#cboxContent{ width:764px !important;}
#cboxLoadedContent{ width:764px !important;}
.left_column { background: none repeat scroll 0 0 #ecebeb; border-radius: 10px; clear: both; float: left !important; margin-bottom: 10px; margin-right: 200px; padding: 10px; position:relative; margin-top: 16px;}
.right_column { background: none repeat scroll 0 0 #0084ff; border-radius: 10px; clear: both; color: #ffffff; float: right; margin-bottom: 10px; margin-left: 200px; padding: 10px; position:relative; margin-top: 16px; }
#chatTranscription { margin: 0 auto; width: 98%; overflow: scroll; height:500px; overflow-x:hidden; padding-right: 20px; }
.leftlabel { bottom: -18px; color: #656668; font: italic 11px/1 Arial,Helvetica,sans-serif; left: 8px; position: absolute; }
.rightlabel { bottom: -18px; color: #656668; font: italic 11px/1 Arial,Helvetica,sans-serif; right: 8px; position: absolute;}
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

.bg-white{position: relative;}
#container-body {
    width: 77% !important;
	margin:0 auto;
}

</style>
<?php include('head_include.php');?>
</head>

<script type="text/javascript">
$(document).ready(function() {
	$(".head_title").text("Events");
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function reset_do()
{
	//window.location.href=window.location.href
	var id = getParameterByName('id');
	window.location.href= "?id="+id;
	
}

</script>

<body class="hybrid"  style="overflow-x:hidden;">
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

													});
                                                </script>                                      
                                    

                                       <div class="frm_buttons">        
                                            <input class="active_btn" type="submit" name="search" value="Apply Filter"> 
                                            <!--<input class="default_btn" type="button" value="Reset to Default" onClick="window.location.href=window.location.href">
                                            -->
                                                                                        <input class="default_btn" type="button" value="Reset to Default" onClick="return reset_do();" >

                                            
                                       </div>                                        

                                   
                                    </form>
                                </div>
                            </div>		
                        </div>          
                        <div class="filter-box-bg item-hide"></div>
                        <div class="clearB"></div>

                    </div>
                        </div>
                        <div class="clearB"></div>
                        <script type="text/javascript">
							var chart = AmCharts.makeChart("chartfunnel", {
							"type": "funnel",
							"theme": "none",
							
							<?php 
							
							//foreach ($impression as $impression_value) {
								//echo    $impression_value." : ".$click[$i]." : ".$event[$i]."</br>" ;
								//$i++;
							//}	
							
								$funnel_arr = array();
								foreach ($impression as $key => $impression_value) {
									$iv = number_format($impression_value);
									$click = number_format($click[$key]);
									$event = number_format($event[$key]);
						//			//echo    $impression_value." : ".$click[$key]." : ".$event[$i]."</br>" ;
						//			//$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'{$impression_value}'},{\"title\": \"Click\",\"value\":'{$click[$key]}'},{\"title\": \"Event\",\"value\":'{$event[$key]}'}";
									$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'210',\"number\":'{$iv}'},{\"title\": \"Click\",\"value\":'200',\"number\":'{$click}'},{\"title\": \"Event\",\"value\":'150',\"number\":'{$event}'}";
						//			$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'6'},{\"title\": \"Click\",\"value\":'9'},{\"title\": \"Event\",\"value\":'13'}";
								}
						//		
								$f_funnel = implode(",",$funnel_arr);
						?>
						
							"dataProvider": [<?php echo $f_funnel; ?>],
							"balloon": {
								"fixedPosition": true
							},
							"valueField": "value",
							"titleField": "title",
							"marginRight": 240,
							"marginLeft": 50,
							"startX": -500,
							"depth3D": 40,
							"angle": 40,
							"color": ["#D50D00", "#D65500", "#02B11B"],
							"outlineAlpha": 1,
							"labelText": "[[title]]: [[number]]",
							"sequencedAnimation": false,
							"startDuration": 0,
							"outlineColor": "#FFFFFF",
							"outlineThickness": 2,
							"labelPosition": "right",
							"balloonText": "[[title]]: [[number]]",
							"exportConfig": {
								"menuItems": [{
									"icon": '/lib/3/images/export.png',
									"format": 'png'
								}]
							}
						});

                        </script>
                        <style>
                        #chartfunnel {width: 70%; height: 435px;font-size: 11px; float:right; clear:both;}	
                        </style>
						<div id="chartfunnel"></div>                        
                   
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                    <th width="20%">Date</th>
                                    <th width="10%">Time</th>
                                    <th width="20%">Event</th>
                                    <th width="20%">Action/Info </th>
                                    <th width="30%">Details </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							
							$i = 0;
								foreach ($date as $key => $date_value):
									//echo    $date_value." : ".$chat_start_dtm[$key]." : ".$chat_duration[$key]." : ".$city." ".$state." ".$country." : ".$chat_lead_status[$key]." : </br>";//.$notes[$i]."</br>" ;
							?>
							<tr class="odd">
						        <td class="date_data">
                                    <?php  // $date_prefix; echo date(" M 'y - H:i:s",strtotime($date)); ?>
                                    <!--5th May '14 - 11:58:01-->
                                    <?php //echo $date_value; ?>
                                    
                                    <?php 
									echo $date_value; 
									//$date_time = explode(" ", $datetime);
									
    								?>
                               	</td>
							    <td><?php //echo $chat_start_dtm[$key].' / '; ?>
                                	<?php 
									 echo $time[$key] ;
										
									?>
                                </td>
						        <td class="time_data"><?php echo $eventCategory[$key];
		  ?></td>
                                <td><?php echo $eventAction[$key] ;
		 ?></td>
                              	<td class="call_data"><?php echo $eventLabel[$key];  ?></td>
   								<!-- <td align="center"><img src="Images/call-tracking-icon-2.png" /></td>-->
							   
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

</body>
</html>