<?php
// Report all errors except E_NOTICE
//error_reporting(0);
date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  

///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//

$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/companies/8900/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  




///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//

$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/reports/leads/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  




///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//
$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/reports/transcripts/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  
 
	
	
	
	
			
///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//
$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/reports/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  



			
///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//
$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/leads/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  
     
	
				
///-----------------------------------------------------------------------//
//---------curl to fetch the reports data-----------------------------------//
$request_url = "http://www.apexchat.com/Services/ApexChatService.svc/companies/?start=0&_nocache=123456";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
pr($result_lead);  
 
	
			
echo " Cron Job to fetch chat info ran successfully" ;		
			
 ?>
                           
                         
