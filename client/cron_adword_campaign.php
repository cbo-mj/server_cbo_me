<?php
@session_start();
//error_reporting(0);
include("include/connection.php");
include("include/login_setting.php");
//include("include/common_function.php");


$startIndex=1;//start index
$maxResults=500000000;//last index
$endDate_before_today = date('Y-m-d', strtotime('today - 1 days'));		
$startDate_before_30_days = date('Y-m-d', strtotime('today - 30 days'));
$startDate_before_365_days = date('Y-m-d', strtotime('today - 365 days'));
$today = date('Y-m-d', strtotime('today'));


require_once dirname(__FILE__) . '/init.php';
require_once dirname(__FILE__) . '/reports.php';
$obj = new AdwordsReports;



//print_r($login_detail); die;
for($i=0; $i<sizeof($login_detail); $i++)
{
	//$email = ga_email;	
	$email = $login_detail[$i]['email'];
	$password = $login_detail[$i]['password'];	
	

	$sql = "SELECT * FROM  adword_root_acc where email = '$email' ";
	$result = mysql_query($sql) or die (mysql_error());	
	
	if( mysql_num_rows($result) == 1 )
	{
		$row = mysql_fetch_assoc($result);
		
		$client_id = $row['client_id'];
		$client_secret = $row['client_secret'];	
		$refresh_token = $row['refresh_token'];	
		$customerId =  $row['customerId'];
		
		$oauth2Info['client_id'] = $client_id;
		$oauth2Info['client_secret'] = $client_secret;
		$oauth2Info['refresh_token'] = $refresh_token;
					
					
		$sql = "SELECT * FROM  adword_child_links_acc where managerCustomerId = '$customerId' ";
		$result = mysql_query($sql) or die (mysql_error());					
	
	
		while($row = mysql_fetch_assoc($result))
		{
			
			$clientCustomerId = $row["clientCustomerId"];
			//pr($oauth2Info);  
			try {
			$user = new AdWordsUser(NULL, NULL, NULL, NULL, NULL, NULL, $clientCustomerId, NULL, NULL, $oauth2Info);
			$user->LogAll();
			$user->LogDefaults();
			$obj->removeData($clientCustomerId);
			$fileName = dirname(__FILE__) . "/" . $clientCustomerId . "_CampaignPerfomanceReportToday.csv";
			$filePath = $obj->DownloadCampaignPerfomanceReport($user, $fileName);
			$obj->ProcessCampaignsReport($filePath,$clientCustomerId);
			
		
		} catch (Exception $e) {
			echo "<pre>";
			printf("An error has occurred: %s\n", $e->getMessage());
		}		
		
	
	}
	
	
	}

}

echo '<h1 style="color:green">Cron Run Successfully for the Store Google Adword Campaign Data cron</h1>';




?>