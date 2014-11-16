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
<?
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
$sql_week = "SELECT DAYNAME(a.`date`) as day,sum(a.`totalEvents`) as event FROM `ga_event_category_history_data` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by DAYNAME(a.`date`) ORDER BY FIELD(DAYNAME(a.date), 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
 
$sql_month = "SELECT MONTHNAME(a.`date`) as month,sum(a.`totalEvents`) as event FROM `ga_event_category_history_data` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by MONTHNAME(a.`date`) order by a.`date` asc  ";

$sql_year =  "SELECT a.`date` as date , sum(a.`totalEvents`) as event FROM `ga_event_category_history_data` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE year(a.`date`) = year(now()) and b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql
group by a.`date` order by a.`date` asc  ";

 $sql_year_graph =  "SELECT sum(c.impressions) as impressions, sum(c.clicks) as clicks, sum(a.`event`) as event from ((SELECT a.date,a.adwordsCampaignID, sum(a.`totalEvents`) as `event` FROM `ga_event_category_data_365_days` a GROUP BY a.date,a.adwordsCampaignID) a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id inner join (SELECT c.date, c.adwordsCampaignID, sum(c.impressions) as impressions, sum(c.adClicks) as clicks from ga_adword_campaign_data_history c group by c.date, c.adwordsCampaignID) c on a.adwordsCampaignID = c.adwordsCampaignID and a.date = c.date) WHERE b.campaign_type = 4 and b.client_id = '$client_id' and $date_sql";
	
	
}else{
   $sql_hour = "SELECT a.`hour` as hour, sum(a.`totalEvents`) as event FROM `ga_data_campaign_event` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id where 
  b.client_id = '$client_id' and date(a.date )>= now()-interval 1 month 
  group by a.`hour` order by a.`hour`" ;
   
$sql_week = "SELECT DAYNAME(a.`date`) as day,sum(a.`totalEvents`) as event FROM `ga_event_category_data_30_days` a inner join group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id'
group by DAYNAME(a.`date`) ORDER BY FIELD(DAYNAME(date), 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
 
$sql_month = "SELECT MONTHNAME(a.`date`) as month,sum(a.`totalEvents`) as event FROM `ga_event_category_data_365_days` a inner join 
group_campaign_link b on a.adwordsCampaignID = b.campaign_id
WHERE b.campaign_type = 4 and b.client_id = '$client_id'
group by MONTHNAME(`date`) order by a.`date` asc  ";

$sql_year =  "SELECT a.`date` as date , sum(a.`totalEvents`) as event FROM `ga_event_category_data_365_days` a inner join 
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
		  $hour[] = $ga_hour_data['hour'];
		  $hour_event[] = $ga_hour_data['event'];
		}
	}

	
	if(mysql_num_rows($rs_week_data)>0){  
		while($ga_week_data = mysql_fetch_assoc($rs_week_data)){
		  $week_day[] = $ga_week_data['day'];
		  $week_event[] = $ga_week_data['event'];
		}
	}
	

	
	if(mysql_num_rows($rs_month_data)>0){  
		while($ga_month_data = mysql_fetch_assoc($rs_month_data)){
		  $month_name[] = $ga_month_data['month'];
		  $month_event[] = $ga_month_data['event'];
		}
	}
	

	
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
	
	echo " Event by the year graph: "."</br>";
	echo "IMPRESSION"." : "."CLICK"." : "."EVENT"."</br>" ;
		  
	$i=0;
	foreach ($impression as $impression_value) {
		echo    $impression_value." : ".$click[$i]." : ".$event[$i]."</br>" ;
		$i++;
	}
?>
<script type="text/javascript">
var chart = AmCharts.makeChart("chartfunnel", {
    "type": "funnel",
    "theme": "none",
	
	<?php 
//		$funnel_arr = array();
//		foreach ($impression as $key => $impression_value) {
//			//echo    $impression_value." : ".$click[$key]." : ".$event[$i]."</br>" ;
//			//$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'{$impression_value}'},{\"title\": \"Click\",\"value\":'{$click[$key]}'},{\"title\": \"Event\",\"value\":'{$event[$key]}'}";
//			$funnel_arr[] = "{\"title\": \"Impressions\",\"value\":'6'},{\"title\": \"Click\",\"value\":'9'},{\"title\": \"Event\",\"value\":'13'}";
//        }
//		
//		$f_funnel = implode(",",$funnel_arr);
?>

    "dataProvider": [{
        "title": "Impressions",
        "value": '210',
        "number": '74,765,068'
    }, {
        "title": "Click",
        "value": '200',
        "number": '771,836'
    }, {
        "title": "Event",
        "value": '150',
        "number": '19,260'
    }],
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

//var chart = AmCharts.makeChart("chartfunnel", {
//"type": "funnel",
//"theme": "none",
//"dataProvider": [{"title": "Impressions","value":'6'},{"title": "Click","value":'9'},{"title": "Event","value":'13'}],
//"balloon": {
//"fixedPosition": true
//},
//"valueField": "value",
//"titleField": "title",
//"marginRight": 240,
//"marginLeft": 50,
//"startX": -500,
//"depth3D":40,
//"angle":40,
//"outlineAlpha":1,
//"outlineColor":"#FFFFFF",
//"outlineThickness":2,
//"labelPosition": "right",
//"balloonText": "[[title]]: [[value]]n[[description]]",
//"exportConfig":{
//"menuItems": [{
//"icon": '/lib/3/images/export.png',
//"format": 'png'
//}]
//}
//}); 

</script>