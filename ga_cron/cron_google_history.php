<?php
@session_start();
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");
require 'include/gapi.class.php';
include("include/ga_function.php");
include("include/login_setting.php");

/*define('ga_email','google2@cbo.me');//your gmail username
define('ga_password','PUnCETdfjlWCpFm8');//your gmail password
$ga = new gapi(ga_email,ga_password);*/

$startIndex=1;//start index
$maxResults=500000000;//last index
$endDate_before_today = date('Y-m-d', strtotime('today - 1 days'));		
$startDate_before_30_days = date('Y-m-d', strtotime('today - 30 days'));
$startDate_before_365_days = date('Y-m-d', strtotime('today - 365 days'));
$today = date('Y-m-d', strtotime('today'));


//print_r($login_detail); die;
for($i=0; $i<sizeof($login_detail); $i++)
{
	//$email = ga_email;	
	$email = $login_detail[$i]['email'];
	$password = $login_detail[$i]['password'];	
	$ga = new gapi($email,$password);

	$sql = "SELECT * FROM  ga_property where email = '$email' ";
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result))
	{
			$ga_profile_id = $row['profile_id'];
			$ga_account_id = $row['account_id'];
			
get_history_for_category_event_queryCoreReportingApi($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);

$sql_ins_30_day_event_cat = "insert into ga_event_category_data_30_days (`account_id`, `profile_id`, `date`, `eventCategory`, `totalEvents`, `created_date_time`, `updated_date_time`, `eventAction`, `eventLabel`, `hour`, `minute`, `medium`, `adwordsCampaignID`) SELECT `account_id`, `profile_id`, `date`, `eventCategory`, `totalEvents`, `created_date_time`, `updated_date_time`, `eventAction`, `eventLabel`, `hour`, `minute`, `medium`, `adwordsCampaignID`  FROM `ga_event_category_history_data` where `date` > (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END from ga_event_category_data_30_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id') and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

$sql_del_30_day_event_cat = "delete from ga_event_category_data_30_days where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_30_day_event_cat) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_event_cat) or die ( mysql_error() ) ;

$sql_ins_365_day_event_cat = "insert into ga_event_category_data_365_days (`account_id`, `profile_id`, `date`, `eventCategory`, `totalEvents`, `created_date_time`, `updated_date_time`, `eventAction`, `eventLabel`, `hour`, `minute`, `medium`, `adwordsCampaignID`) SELECT `account_id`, `profile_id`, `date`, `eventCategory`, `totalEvents`, `created_date_time`, `updated_date_time`, `eventAction`, `eventLabel`, `hour`, `minute`, `medium`, `adwordsCampaignID`  FROM `ga_event_category_history_data` where `date`> (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END from ga_event_category_data_365_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id') and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_365_day_event_cat = "delete from ga_event_category_data_365_days where `date` < DATE_SUB(NOW(), INTERVAL 365 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_365_day_event_cat) or die ( mysql_error()) ;

mysql_query($sql_del_365_day_event_cat) or die ( mysql_error() ) ;
			
ga_adword_event_data_history($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);

$sql_ins_30_day_adword_event = "insert into ga_adword_event_data_30_days ( `account_id`, `profile_id`, `date`, `impressions`, `adClicks`, `CTR`, `totalEvents`, `created_date_time`, `updated_date_time`) SELECT  `account_id`, `profile_id`, `date`, `impressions`, `adClicks`, `CTR`, `totalEvents`, `created_date_time`, `updated_date_time`  FROM `ga_adword_event_data_history` where `date` > (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END  from ga_event_category_data_30_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_30_day_adword_event = "delete from ga_adword_event_data_30_days where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

mysql_query($sql_ins_30_day_adword_event) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_adword_event) or die ( mysql_error() ) ;
			
ga_adword_campaign_data_history($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);

$sql_ins_30_day_adword_campaign = "insert into ga_adword_campaign_data_30_days (`account_id`, `profile_id`, `date`, `adwordsCampaignID`, `impressions`, `adClicks`, `CTR`, `CPC`, `CPM`, `adCost`, `sessions`, `created_date_time`, `updated_date_time`)  SELECT `account_id`, `profile_id`, `date`, `adwordsCampaignID`, `impressions`, `adClicks`, `CTR`, `CPC`, `CPM`, `adCost`, `sessions`, `created_date_time`, `updated_date_time`  FROM `ga_adword_campaign_data_history` where `date` > (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END from ga_adword_campaign_data_30_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_30_day_adword_campaign = "delete from ga_adword_campaign_data_30_days where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

mysql_query($sql_ins_30_day_adword_campaign) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_adword_campaign) or die ( mysql_error() ) ;
			
get_history_queryCoreReportingApi($ga,'2012-01-01',$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id); 

/*$sql_ins_30_day_ga_data = "insert into ga_data_30_days SELECT * FROM `all_ga_data_history` where `date` > (select max(`date`) from ga_data_30_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_30_day_ga_data = "delete from ga_data_30_days where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_30_day_ga_data) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_ga_data) or die ( mysql_error() ) ;*/

/*$sql_ins_365_day_ga_data = "insert into ga_data_365_days SELECT * FROM `all_ga_data_history` where `date`> (select max(`date`) from ga_data_365_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_365_day_ga_data = "delete from ga_data_365_days where `date` < DATE_SUB(NOW(), INTERVAL 365 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_365_day_ga_data) or die ( mysql_error() ) ;

mysql_query($sql_del_365_day_ga_data) or die ( mysql_error() ) ;*/
	
get_history_for_platform_queryCoreReportingApi($ga,'2012-01-01',$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);

$sql_ins_30_day_ga_platform = "insert into ga_data_platform_30_days (`account_id`, `profile_id`, `date`, `ga_deviceCategory`, `ga_users`, `created_date_time`, `updated_date_time`) SELECT `account_id`, `profile_id`, `date`, `ga_deviceCategory`, `ga_users`, `created_date_time`, `updated_date_time` FROM `all_ga_data_platform_history` where `date` > (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END from ga_data_platform_30_days where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_30_day_ga_platform = "delete from ga_data_platform_30_days where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_30_day_ga_platform) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_ga_platform) or die ( mysql_error() ) ;

		
campaign_event_history($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);

$sql_ins_30_day_campaign_event = "insert into campaign_event_30_day (`account_id`, `profile_id`, `date`, `adwordsCampaignID`, `totalEvents`, `created_date_time`, `updated_date_time`) SELECT `id`, `account_id`, `profile_id`, `date`, `adwordsCampaignID`, `totalEvents`, `created_date_time`, `updated_date_time` FROM `campaign_event_history` where `date` > (select CASE WHEN ISNULL(max(`date`)) THEN '2012-01-01' ELSE max(`date`) END from campaign_event_30_day where account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' ) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id'" ;

$sql_del_30_day_campaign_event = "delete from campaign_event_30_day where `date` < DATE_SUB(NOW(), INTERVAL 30 DAY) and account_id= '$ga_account_id' and 
profile_id= '$ga_profile_id' " ;

mysql_query($sql_ins_30_day_ga_platform) or die ( mysql_error() ) ;

mysql_query($sql_del_30_day_ga_platform) or die ( mysql_error() ) ;
					
	}

}

echo '<h1 style="color:green">Cron Run Successfully for the Store Google Analytics Data In Database</h1>';




?>