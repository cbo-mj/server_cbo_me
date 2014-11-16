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

$sql_delete_todays_data = "truncate table ga_todays_data"; 
mysql_query($sql_delete_todays_data) or die ( mysql_error() ) ;


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
			
			
			get_30_day_campaign_data_with_event($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
				
			
		
	get_30_days_adword_data_with_event($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
		
		
			
	get_30_days_adword_keyword_data($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
		get_30_days_adword_data($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
				
					
		get_30_days_queryCoreReportingApi($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
		get_365_days_queryCoreReportingApi($ga,$startDate_before_365_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
		get_30_days_for_platform_queryCoreReportingApi($ga,$startDate_before_30_days,$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
	
	
	get_history_queryCoreReportingApi($ga,'2012-01-01',$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
	
	get_history_for_platform_queryCoreReportingApi($ga,'2012-01-01',$endDate_before_today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id);
	
	get_todays_queryCoreReportingApi($ga,$today,$today,$startIndex,$maxResults,$ga_profile_id,$ga_account_id); 
	
	
	}

}

echo '<h1 style="color:green">Cron Run Successfully for the Store Google Analytics Data In Database</h1>';




?>